<!DOCTYPE html>
<html>
<head>
	<title>GEMA SAS</title>
  <link href="./main.css" rel="stylesheet">
</head>
<body>
  <div class="section_wrapper">
    <div class="section">
      <div class="section_title">
        <span> GEMA SAS </span>
      </div>

      <div class="section_content">
        <button id="volver">Volver</button>

        <?php
          $excluded_fields = ["id_usuario", "estado_usuario", "codigo_revisor"];
        ?>

        <?php
          if ( !isset($db) ) {
            include "conexion.php";
            $db = get_conexion();
          }

          $sql = "SELECT * FROM estado";
          $states = $db->query($sql);

          foreach ($states as $record_state) {
            $id = $record_state['id_estado'];

            echo(
              '<span class="section_estado_title"> Usuarios '.
              strtolower($record_state['desc_estado']).
              's</span>'
            );

            $result = $db->query(
              "SELECT U.*, (CASE WHEN U.codigo_revisor IS NULL THEN NULL ELSE CONCAT(R.nombre, ' ', R.apellido) END) AS revisor FROM usuario AS U LEFT JOIN revisores AS R ON R.id = U.codigo_revisor WHERE U.estado_usuario = ".$id
            );

            echo "<table><tr>";

            if ($result->num_rows > 0) {
              $count = 0;

              while($row = $result->fetch_assoc()) {
                if ( $count == 0 ) {
                  foreach (array_keys($row) as $header) {
                    if ( !(in_array($header, $excluded_fields)) ) {
                      $header = str_replace('_', ' ', $header);
                      $header = str_replace('usuario', '', $header);
                      $header = strtoupper(substr($header, 0, 1)).
                        strtolower(substr($header, 1));
                      echo(
                        "<th class='usuario_cell cell_header'>".
                        $header.
                        "</th>"
                      );
                    }
                  };
                  echo "</tr><tr>";
                }

                $count += 1;

                foreach (array_keys($row) as $header) {
                  if ( !(in_array($header, $excluded_fields)) ) {
                    echo("<td class='usuario_cell'>".$row[$header]."</td>");
                  }
                };
                echo "</tr><tr>";
              }
            }

            echo "</tr></table>";

          };
          $db->close();
        ?>
      </div>
    </div>
  </div>


  <script>
    document.querySelector("#volver").addEventListener('click', function (e) {
      history.back();
    });
  </script>
</body>
</html>