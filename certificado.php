<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$this->group('/solicitud', function () {

    $this->post('/login', function (Request $request, Response $response, array $args){
        $login = $request->getParsedBody();
        $appConfig = $this->get('settings')['configuration'];

        if ($login['username'] == $appConfig['username'] 
            && $login['password'] == $appConfig['password']) {
            $_SESSION['LOGIN'] = 'TRUE';    
            return $this->response->withJson(TRUE);
        }
        else 
        {
            $_SESSION['LOGIN'] = '';                    
            return $this->response->withJson(FALSE);                        
        }        
    });

    $this->group('/certificado', function () {

        $this->get('/test', function (Request $request, Response $response, array $args) {
            echo $request->getUri()->getBaseUrl();
        });

        $this->get('', function (Request $request, Response $response, array $args) {
            $sth = $this->db->prepare("SELECT *, CONVERT_TZ(fecha,'+00:00','+00:00') as fecha, MD5(id_solicitud_certificado) as code FROM solicitud_certificado ORDER BY fecha DESC");
            $sth->execute();
            $todos = $sth->fetchAll();
            return $this->response->withJson($todos);
        });

        $this->get('/{id}', function (Request $request, Response $response, array $args) {
            $sth = $this->db->prepare("SELECT *, CONVERT_TZ(fecha,'+00:00','+00:00') as fecha FROM solicitud_certificado WHERE MD5(id_solicitud_certificado)=:id");
            $sth->bindParam("id", $args['id']);
            $sth->execute();
            $todos = $sth->fetchObject();
            return $this->response->withJson($todos);
        });


        $this->get('/estado/{estado}', function (Request $request, Response $response, array $args) {
            $sth = $this->db->prepare("SELECT *, CONVERT_TZ(fecha,'+00:00','+00:00') as fecha, MD5(id_solicitud_certificado) as code FROM solicitud_certificado WHERE estado=:estado ORDER BY fecha DESC");
            $sth->bindParam("estado", $args['estado']);
            $sth->execute();
            $todos = $sth->fetchAll();
            return $this->response->withJson($todos);
        });

        $this->get('/documento/{documento}', function (Request $request, Response $response, array $args) {
            $sth = $this->db->prepare("SELECT *, CONVERT_TZ(fecha,'+00:00','+00:00') as fecha, MD5(id_solicitud_certificado) as code FROM solicitud_certificado WHERE documento=:documento ORDER BY fecha DESC");
            $sth->bindParam("documento", $args['documento']);
            $sth->execute();
            $todos = $sth->fetchAll();
            return $this->response->withJson($todos);
        });

        $this->get('/excel/documento/{documento}', function (Request $request, Response $response, array $args) {
            $sth = $this->db->prepare("SELECT *, CONVERT_TZ(fecha,'+00:00','+00:00') as fecha, MD5(id_solicitud_certificado) as code FROM solicitud_certificado WHERE documento=:documento ORDER BY fecha DESC");
            $sth->bindParam("documento", $args['documento']);
            $sth->execute();

            $content = $response->getBody();
                $content->write(
                    'id'.";".
                    'fecha'.";".
                    'documento'.";".
                    'nombres'.";".
                    'apellidos'.";".
                    'cargo'.";".
                    'ciudad'.";".
                    'telefono_fijo'.";".
                    'telefono_movil'.";".
                    'correo'.";".
                    'tipo_certificado'.";".
                    'asunto'.";".
                    'estado'.";".
                    'fecha_estado'.";".
                    'observacion'.";".
                    'archivo'."\n"
                );
            foreach ($sth as $row) {
                $content->write(
                    $row['id_solicitud_certificado'].";".
                    $row['fecha'].";".
                    $row['documento'].";".
                    $row['nombres'].";".
                    $row['apellidos'].";".
                    $row['cargo'].";".
                    $row['ciudad'].";".
                    $row['telefono_fijo'].";".
                    $row['telefono_movil'].";".
                    $row['correo'].";".
                    $row['tipo_certificado'].";".
                    $row['asunto'].";".
                    $row['estado'].";".
                    $row['fecha_estado'].";".
                    $row['observacion'].";".
                    $row['archivo']."\n"
                );
            }

            return $response->withHeader('Content-Type', 'text/csv;charset=utf-8')
                //->withHeader('Content-Transfer-Encoding', 'binary')
                ->withHeader('Content-Disposition', 'attachment;filename=informe_solicitudes.csv')
                ->withHeader('Expires', '0')
                ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                ->withHeader('Pragma', 'public');                

            //return $this->response->withJson($todos);
        });

        $this->get('/excel/estado/{estado}', function (Request $request, Response $response, array $args) {
            $sth = $this->db->prepare("SELECT *, CONVERT_TZ(fecha,'+00:00','+00:00') as fecha, MD5(id_solicitud_certificado) as code FROM solicitud_certificado WHERE estado=:estado ORDER BY fecha DESC");
            $sth->bindParam("estado", $args['estado']);
            $sth->execute();

            $content = $response->getBody();
                $content->write(
                    'id'.";".
                    'fecha'.";".
                    'documento'.";".
                    'nombres'.";".
                    'apellidos'.";".
                    'cargo'.";".
                    'ciudad'.";".
                    'telefono_fijo'.";".
                    'telefono_movil'.";".
                    'correo'.";".
                    'tipo_certificado'.";".
                    'asunto'.";".
                    'estado'.";".
                    'fecha_estado'.";".
                    'observacion'.";".
                    'archivo'."\n"
                );
            foreach ($sth as $row) {
                $content->write(
                    $row['id_solicitud_certificado'].";".
                    $row['fecha'].";".
                    $row['documento'].";".
                    $row['nombres'].";".
                    $row['apellidos'].";".
                    $row['cargo'].";".
                    $row['ciudad'].";".
                    $row['telefono_fijo'].";".
                    $row['telefono_movil'].";".
                    $row['correo'].";".
                    $row['tipo_certificado'].";".
                    $row['asunto'].";".
                    $row['estado'].";".
                    $row['fecha_estado'].";".
                    $row['observacion'].";".
                    $row['archivo']."\n"
                );
            }

            return $response->withHeader('Content-Type', 'text/csv;charset=utf-8')
                //->withHeader('Content-Transfer-Encoding', 'binary')
                ->withHeader('Content-Disposition', 'attachment;filename=informe_solicitudes.csv')
                ->withHeader('Expires', '0')
                ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                ->withHeader('Pragma', 'public');                

            //return $this->response->withJson($todos);
        });

        $this->get('/excel/todas', function (Request $request, Response $response, array $args) {
            $sth = $this->db->prepare("SELECT *, CONVERT_TZ(fecha,'+00:00','+00:00') as fecha, MD5(id_solicitud_certificado) as code FROM solicitud_certificado ORDER BY fecha DESC");
            $sth->execute();

            $content = $response->getBody();
                $content->write(
                    'id'.";".
                    'fecha'.";".
                    'documento'.";".
                    'nombres'.";".
                    'apellidos'.";".
                    'cargo'.";".
                    'ciudad'.";".
                    'telefono_fijo'.";".
                    'telefono_movil'.";".
                    'correo'.";".
                    'tipo_certificado'.";".
                    'asunto'.";".
                    'estado'.";".
                    'fecha_estado'.";".
                    'observacion'.";".
                    'archivo'."\n"
                );
            foreach ($sth as $row) {
                $content->write(
                    $row['id_solicitud_certificado'].";".
                    $row['fecha'].";".
                    $row['documento'].";".
                    $row['nombres'].";".
                    $row['apellidos'].";".
                    $row['cargo'].";".
                    $row['ciudad'].";".
                    $row['telefono_fijo'].";".
                    $row['telefono_movil'].";".
                    $row['correo'].";".
                    $row['tipo_certificado'].";".
                    $row['asunto'].";".
                    $row['estado'].";".
                    $row['fecha_estado'].";".
                    $row['observacion'].";".
                    $row['archivo']."\n"
                );
            }

            return $response->withHeader('Content-Type', 'text/csv;charset=utf-8')
                //->withHeader('Content-Transfer-Encoding', 'binary')
                ->withHeader('Content-Disposition', 'attachment;filename=informe_solicitudes.csv')
                ->withHeader('Expires', '0')
                ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                ->withHeader('Pragma', 'public');                

        });

    // Update estado solicitud (2 metodos)
$this->put('', function (Request $request, Response $response, array $args) {
    $solicitud = $request->getParsedBody();
    $estado = '';
    $path = $request->getUri()->getBaseUrl().'/../app';
            switch ($solicitud['estado']) {
                case "-1":
                    $estado = "RECHAZADA";
                    $sth = $this->db->prepare("UPDATE solicitud_certificado SET estado = :estado, fecha_estado = NOW(), observacion = :observacion WHERE MD5(id_solicitud_certificado) =:id");
                    $sth->bindParam("id", $solicitud['xzy']);
                    $sth->bindParam("estado", $estado);
                    $sth->bindParam("observacion", $solicitud['observacion']);        
                    
        $this->mail->clearAllRecipients();
                $this->mail->setFrom('solicitudes@atlas.com.co', 'ATLAS a un click!');

                    $this->mail->addAddress($solicitud['correo_notificacion'], $solicitud['nombre_notificacion']);
                    $this->mail->isHTML(true);
                    $this->mail->Subject = 'A un solo click ha rechazado tu solicitud';
                    $this->mail->Body = '<h3>A un solo click ha rechazado tu solicitud</h3>' .
                    '<p>Lamentamos informarte que la solicitud no puede ser atendida.</p>' .
		    '<p>Te invitamos a hacer <a href="'.$path.'/estadoSolicitud.php?xzy=' .$solicitud['xzy'].'">click aquí</a> para ver los detalles sobre esta novedad</p>'.
                    '<p>Gracias por contactarnos!</p>';
                    
                    if($this->mail->send()) {
                        $result = TRUE;
                    } else {
                        //echo "Email sent!" , PHP_EOL;
                    }

                    break;
                case "1":
                    $estado = "ACEPTADA";
                    $sth = $this->db->prepare("UPDATE solicitud_certificado SET estado = :estado, fecha_estado = NOW(), observacion = '' WHERE MD5(id_solicitud_certificado) =:id");
                    $sth->bindParam("id", $solicitud['xzy']);
                    $sth->bindParam("estado", $estado);

            $this->mail->clearAllRecipients();
                $this->mail->setFrom('solicitudes@atlas.com.co', 'ATLAS a un click!');

                    $this->mail->addAddress($solicitud['correo_notificacion'], $solicitud['nombre_notificacion']);
                    $this->mail->isHTML(true);
                    $this->mail->Subject = 'A un solo click ha aceptado tu solicitud';
                    $this->mail->Body = '<h3>A un solo click ha aceptado tu solicitud</h3>'.
                    '<p>Puedes consultar esta solicitud haciendo <a href="'.$path.'/estadoSolicitud.php?xzy=' .$solicitud['xzy'].'">click aquí</a></p>'.
                    '<p>Tan pronto el certificado sea emitido se notificará al correo.</p>'.
                    '<p>Gracias!</p>';

                    if($this->mail->send()) {
                        $result = TRUE;
                    } else {
                        //echo "Email sent!" , PHP_EOL;
                    }
                    
                    break;
                default:
                    echo "error";
                    return;                    
            }

            $sth->execute();
            $input['id'] = $this->db->lastInsertId();
            return $this->response->withJson($input);
        });
        // END Update estado solicitud

        // Estado soicitud ENVIAR Adjunto
        $this->post('/documento', function (Request $request, Response $response, array $args) {
            $solicitud = $request->getParsedBody();
            $uploadedFiles = $request->getUploadedFiles();
            $uploadedFile = $uploadedFiles['certificadoFile'];
            $input['id'] = FALSE;

            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $directory = __DIR__ . "/../../files";
                $filename = $solicitud['xzy'] . '.pdf';
                $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

                $estado = "ATENDIDA";
                $sth = $this->db->prepare("UPDATE solicitud_certificado SET estado = :estado, fecha_estado = NOW(), observacion = '', archivo = :archivo WHERE MD5(id_solicitud_certificado) =:id");
                $sth->bindParam("id", $solicitud['xzy']);
                $sth->bindParam("estado", $estado);
                $sth->bindParam("archivo", $filename);                    

                // correo para el usuario
                $documento_url = $request->getUri()->getBaseUrl().'/../files/'.$filename;

                $this->mail->clearAllRecipients();
                $this->mail->setFrom('solicitudes@atlas.com.co', 'ATLAS a un click!');
                $this->mail->addAddress($solicitud['correo_notificacion'], $solicitud['nombre_notificacion']);
                $this->mail->isHTML(true);
                $this->mail->Subject = 'A un solo click ha atendido tu solicitud';
                $this->mail->Body = '<h3>A un solo click ha atendido tu solicitud</h3>'.
                '<p>Te invitamos a hacer <a href="'.$documento_url.'">click aquí</a> para descargar el certificado solicitado</p>'.
                '<p>Gracias y hasta pronto!</p>';
                if($this->mail->send()) {
                    $result = TRUE;
                } else {
                    //echo "Email sent!" , PHP_EOL;
                }

                $sth->execute();
                $input['id'] = $this->db->lastInsertId();
            }
            return $this->response->withJson($input);
        });

        // POST Add solicitud
        $this->post('', function (Request $request, Response $response, array $args) {
            $solicitud = $request->getParsedBody();
            $sql = "INSERT INTO solicitud_certificado 
            (fecha, documento, nombres, apellidos, cargo, ciudad, telefono_fijo, telefono_movil, correo, tipo_certificado, asunto)
            VALUES (now(),:documento,:nombres,:apellidos,:cargo,:ciudad,:telefono,:movil,:correo,:tipoCertificado,:asunto)";
            $sth = $this->db->prepare($sql);

            $sth->bindParam("documento", $solicitud['documento']);
            $sth->bindParam("nombres", $solicitud['nombres']);
            $sth->bindParam("apellidos", $solicitud['apellidos']);
            $sth->bindParam("cargo", $solicitud['cargo']);
            $sth->bindParam("ciudad", $solicitud['ciudad']);
            $sth->bindParam("telefono", $solicitud['telefono']);
            $sth->bindParam("movil", $solicitud['movil']);
            $sth->bindParam("correo", $solicitud['correo']);
            $sth->bindParam("tipoCertificado", $solicitud['tipoCertificado']);
            $sth->bindParam("asunto", $solicitud['asunto']);
            $sth->execute();
            $input['id'] = $this->db->lastInsertId();
	/*
            $uploadedFiles = $request->getUploadedFiles();
            $uploadedFile = $uploadedFiles['adjuntoFile'];

            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $directory = __DIR__ . "/../../adjuntos";
                $filename = md5($input['id']) . '.pdf';
                $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

                $sql = "UPDATE solicitud_certificado SET adjunto = :adjunto WHERE id_solicitud_certificado = :id_solicitud_certificado";
                $sth = $this->db->prepare($sql);
                $sth->bindParam("adjunto", $filename);
                $sth->bindParam("id_solicitud_certificado", $input['id']);
                $sth->execute();
                
            }
	*/ 
            $appConfig = $this->get('settings')['configuration'];
            $path = $request->getUri()->getBaseUrl().'/../app';

            // correo para el administrador del sistema
            $this->mail->setFrom('solicitudes@atlas.com.co', 'ATLAS a un click!');
            $this->mail->addAddress($appConfig['correo_notificacion'], $appConfig['nombre_notificacion']);
            $this->mail->isHTML(true);
            $this->mail->Subject = 'A un solo click ha recibido una nueva solicitud de certificado';
            $this->mail->Body = '<h3>A un solo click ha recibido una nueva solicitud de certificado</h3>'.
            '<p>Puedes gestionar esta solicitud haciendo <a href="'.$path.'/adminSolicitud.php?xzy=' .md5($input['id']).'">click aquí</a></p>'.
                '<p>O consultar todas las solicitudes pendientes de procesar haciendo <a href="'.$path.'/informeSolicitud.php">click aquí</a>.</p>';
        
            if($this->mail->send()) {
                $result = TRUE;
            } else {
                //echo "Email sent!" , PHP_EOL;
            }

            // correo para el usuario
            $this->mail->clearAllRecipients();
            $this->mail->addAddress($solicitud['correo'], $solicitud['nombres'].' '.$solicitud['apellidos']);
            $this->mail->isHTML(true);
            $this->mail->Subject = 'A un solo click ha recibido tu solicitud';
            $this->mail->Body = '<h3>A un solo click ha recibido tu solicitud</h3>'.
            '<p>Puedes consultar esta solicitud haciendo <a href="'.$path.'/estadoSolicitud.php?xzy=' .md5($input['id']).'">click aquí</a></p>'.
            '<p>Cualquier cambio en el estado de la solicitud se notificará a tu correo.</p>'.
            '<p>Gracias! Pronto te estaremos atendiendo.</p>';
        
            if($this->mail->send()) {
                $result = TRUE;
            } else {
                //echo "Email sent!" , PHP_EOL;
            }

            return $this->response->withJson($input);
            
        });

        // END POST add solicitud


    });
});
