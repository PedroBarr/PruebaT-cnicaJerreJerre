<!DOCTYPE html>
<html>
<head>
	<title>GEMA SAS</title>
  <link href="./main.css" rel="stylesheet">
</head>
<body>
  <!-- PROCSAMIENTO DEL DOCUMENTO -->

  <?php
    function check_have_errors ($row_record) {
      $validator1 = !(in_array($row_record[3], ['1','2', '3'])); // format error
      return $validator1; // true if have errors
    };

    function insert_row_on_database ($row_record, $row_counter) {
      global $db;

      if ( !isset($db) ) {
        include "conexion.php";
        $db = get_conexion();
      }

      $sql = $db->prepare(
        "INSERT INTO usuario (email_usuario, nombre_usuario, apellido_usuario, estado_usuario, codigo_revisor) VALUES (?, ?, ?, ?, ?)"
      );

      $params = $sql->bind_param(
        "sssss",
        $row_record[0],$row_record[1],$row_record[2],$row_record[3],$row_record[4]
      );


      if ($params==false) {
        $error[] = "Fail to set up the query on line ".$row_counter;
      }

      $result = $sql->execute();

      if ($result==false) {
        $error[] = "Fail to insert the data on line ".$row_counter;
      }

      $sql->close();
    };

		if (isset($_POST['submit'])){
      if ( empty( $_FILES['archivoPlano']['name'] ) ) {
        $error[] = "No file was selected for upload.";
      }

      if ( !isset( $error ) ) {
        $lines = file($_FILES['archivoPlano']['tmp_name']);
        $content = file_get_contents($_FILES['archivoPlano']['tmp_name']);
        $n_column_previewed = 5;

        $count_lines = sizeof($lines);
        $count_commas = substr_count($content, ',');
        $count = 0;

        if ( $n_column_previewed - 1 != $count_commas / $count_lines ) {
          $error[] = "Invalid count of data on file";
        } else {
          foreach($lines as $line) {
            $count += 1;

            $data_array = explode(',',$line);
            $data_size = sizeof($data_array);

            if ( $n_column_previewed != $data_size ) {
              $error[] = "Invalid count of data on line ".$count;
              break;
            } else {
              if ( check_have_errors($data_array) ) {
                $error[] = "Invalid format on line ".$count;
                break;

              } else {
                insert_row_on_database($data_array, $count);
              }
            }
          }

          if ( !isset($error) ) {
            header('Location: '.'./visor.php');
          }
        }
      }
    }
	?>

  <!-- FUNCIONALIDAD CARGAR DOCUMENTO -->

  <div class="section_wrapper">
    <div class="section">
      <div class="section_title">
        <span> GEMA SAS </span>
      </div>

      <form
        action=""
        method="POST"
        enctype= multipart/form-data
        class="section_content"
      >
        <span class="section_content_title">
          Formulario de carga de información
        </span>

        <div id="divCargar">
          <span class="filename_preview" id="filenamePreview"></span>

          <input
            type="file"
            id="cargarArchivo"
            name="archivoPlano"
            style="display: none;"
            onchange='getFileData(this)'
          />

          <input
            type="button"
            class="custom_upload_button"
            value="Cargar"
            onclick="document.getElementById('cargarArchivo').click();"
          />
        </div>

        <div id="error-message-container">
          <?php
            if ( isset( $error ) ) {
              foreach ($error as $error ) {
                echo "<span class='error-message'>$error</span>";
              }
            }
          ?>
        </div>

        <div id="divEnviar">
          <input type="submit" value="Enviar formulario" name="submit"/>
        </div>
      </form>
    </div>
  </div>

  <script>
    function getFileData(object) {
      <?php
        function resetErrors () {
          global $error;
          unset($error);
        }

        resetErrors();
      ?>

      if (object) {
        var file = object.files[0];
        if (file) {
          var name = file.name;
          document.getElementById('filenamePreview').innerHTML = name;
          return;
        }
      }

      document.getElementById('filenamePreview').innerHTML = "<?php
        if (
          isset($_FILES['archivoPlano']['name']) and
          $_FILES['archivoPlano']['name']
        ) {
          echo($_FILES['archivoPlano']['name']);
        } else {
          echo "...examinar";
        }
      ?>";
    }

    getFileData(document.getElementById('cargarArchivo'));
  </script>
</body>
</html>