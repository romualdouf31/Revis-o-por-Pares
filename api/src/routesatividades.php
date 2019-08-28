<?php

use Slim\Http\Request;
use Slim\Http\Response;
$app->post('/addatividade', function ($request, $response, $args) {
    $post = $request->getParsedBody();
   
          $str = $this->db->prepare("INSERT INTO atividade (nome, descricao, id_usuario) Values (:nome, :descricao, :id_usuario)"); 
                                       
        $str->bindParam("nome",              $post["nome"]);
        $str->bindParam("descricao",         $post["descricao"]);
        $str->bindParam("id_usuario",         $post["idusuario"]);

        $str->execute();

        $id_atv = $this->db->lastInsertId();

        $sts = $this->db->prepare("INSERT INTO configaval (instrucoes, nrevisores, nrodadas, idenficacaorev, defrevisores, id_atv) Values (:instrucoes,:nrevisores, :nrodadas, :idenficacaorev, :defrevisores, :id_atv)");
        $sts->bindParam("instrucoes",              $post["instrucao"]);
        $sts->bindParam("nrevisores",         $post["nrevisores"]);
        $sts->bindParam("nrodadas",              $post["nrodadas"]);
        $sts->bindParam("idenficacaorev",         $post["idrevisores"]);
        $sts->bindParam("defrevisores",         $post["defrevisores"]);
        $sts->bindParam("id_atv",         $id_atv);
      
        $sts->execute();    
        $stss = $this->db->prepare("INSERT INTO configenvio (instenvio, nmaxanexos, limiteupload, enviosatrasados, identificacaoautores, id_atv) Values (:instenvio,:nmaxanexos,:limiteupload, :enviosatrasados, :identificacaoautores, :id_atv)");
        $stss->bindParam("instenvio",              $post["instenvio"]);
        $stss->bindParam("nmaxanexos",         $post["numanexos"]);
        $stss->bindParam("limiteupload",         $post["limupload"]);
        $stss->bindParam("enviosatrasados",         $post["AcEnvio"]);
        $stss->bindParam("identificacaoautores",         $post["idautores"]);
        
        $stss->bindParam("id_atv",         $id_atv);
        $stss->execute();    
        return $this->response->withJson($post);
   
  });

  $app->put('/editatividade/{id}', function ($request, $response, $args) {
      $post = $request->getParsedBody();
      print_r($post);
            $str = $this->db->prepare("UPDATE atividade set nome =:nome, descricao = :descricao, id_usuario = :id_usuario where id_atv =:id_atv" ); 
                                         
          $str->bindParam("nome",              $post["nome"]);
          $str->bindParam("descricao",         $post["descricao"]);
          $str->bindParam("id_usuario",         $post["idusuario"]);
          $str->bindParam("id_atv",         $args["id"]);
  
          $str->execute();
  
          
  
          $sts = $this->db->prepare("UPDATE configaval  SET instrucoes = :instrucoes, nrevisores = :nrevisores, nrodadas = :nrodadas, idenficacaorev = :idenficacaorev, defrevisores = :defrevisores where id_atv = :id_atv" );
          $sts->bindParam("instrucoes",              $post["instrucao"]);
          $sts->bindParam("nrevisores",         $post["nrevisores"]);
          $sts->bindParam("nrodadas",              $post["nrodadas"]);
          $sts->bindParam("idenficacaorev",         $post["idrevisores"]);
          $sts->bindParam("defrevisores",         $post["defrevisores"]);
          $sts->bindParam("id_atv",         $args["id"]);
        
          $sts->execute();    
          $stss = $this->db->prepare("UPDATE configenvio set instenvio = :instenvio, nmaxanexos =:nmaxanexos , limiteupload = :limiteupload, identificacaoautores = :identificacaoautores, enviosatrasados = :enviosatrasados where id_atv = :id_atv");
          $stss->bindParam("instenvio",              $post["instenvio"]);
          $stss->bindParam("nmaxanexos",         $post["numanexos"]);
          $stss->bindParam("limiteupload",         $post["limupload"]);
          $stss->bindParam("identificacaoautores",  $post["idautores"]);
          $stss->bindParam("enviosatrasados",         $post["AcEnvio"]);
          $stss->bindParam("id_atv",         $args["id"]);
          $stss->execute();    
          return $this->response->withJson($post);
     
    });
  



  $app->get('/listaatividade/{id}', function ($request, $response, $args) {
  
      $str = $this->db->prepare("SELECT * from atividade where id_usuario = ".$args["id"]); 
      $str -> execute();
      $post = $str -> fetchAll();

      return $this->response->withJson($post);
});

$app->get('/atividade/{id}', function ($request, $response, $args) {
  
      $str = $this->db->prepare("SELECT * FROM atividade atv inner join configaval ca on (ca.id_atv = atv.id_atv) inner join configenvio ce on (ce.id_atv = atv.id_atv)
      where atv.id_atv = ".$args["id"]); 
      $str -> execute();
      $post = $str -> fetchAll();

      return $this->response->withJson($post);
});


$app->delete('/excluiratividade/{id}', function ($request, $response, $args) {
  
      $str = $this->db->prepare("DELETE  FROM configaval where id_atv =".$args["id"]);
      $str -> execute();
      $str = $this->db->prepare("DELETE  FROM configenvio where id_atv =".$args["id"]);
      $str -> execute();
      $str = $this->db->prepare("DELETE  FROM atividade where id_atv =".$args["id"]);
      $str -> execute();
      $ok = "true";
      return $this->response->withJson($ok);
});