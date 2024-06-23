<?php
include ('../conexao.php');

if (isset($_GET['cursoId'])) {
    $cursoId = intval($_GET['cursoId']);
    
    $sqlCurso = "SELECT * FROM curso WHERE Curso_id = $cursoId";
    $resultadoCurso = $conn->query($sqlCurso);
    
    if ($resultadoCurso && $resultadoCurso->num_rows > 0) {
        $curso = $resultadoCurso->fetch_assoc();
        
        $sqlModulos = "SELECT mc.*, m.Modulo_Nome FROM modulo_curso mc
                       JOIN modulo m ON mc.Modulo_Modulo_cd = m.Modulo_id
                       WHERE mc.Curso_Curso_cd = $cursoId";
        $resultadoModulos = $conn->query($sqlModulos);
        
        $modulos = array();
        
        if ($resultadoModulos && $resultadoModulos->num_rows > 0) {
            while ($row = $resultadoModulos->fetch_assoc()) {
                $modulos[] = $row;
            }
        }
        
        $curso['modulos'] = $modulos;
        
        header('Content-Type: application/json');
        echo json_encode($curso);
    } else {
        echo json_encode(array('error' => 'Nenhum curso encontrado.'));
    }
} else {
    echo json_encode(array('error' => 'ID do curso não fornecido.'));
}
?>
