<?php
include('../includes/config.php');
include('../classes/conectar.php');
include('../classes/crud.php');
$con = new Connection($server,$user,$password,$dbname);
                $stot=0;
                $fecha=date('Y-m-d', strtotime('-1 month'));
                $con->conectar();
                $crud = new Crud();
                $crud->setconsulta("select count(id) as cot from cotizacion_maestro where fecha_cotizacion >= '$fecha'");
                $datos_usuario =  $crud->seleccionar($con->getConnection());
                $tcot=$datos_usuario[0]['cot'];
                if ($tcot==0){
                  $tcot=1;
                  $stot=1;
                }
                $crud2 = new Crud();
                $crud2->setconsulta("select count(mc.id) as cot from cotizacion_maestro mc
                                    inner join estados es
                                    on es.id=mc.estado
                                    where estado=9 and fecha_cotizacion >= '$fecha'");
                $datos_usuario =  $crud2->seleccionar($con->getConnection());
                $acot=$datos_usuario[0]['cot'];
                if ($acot==null or $acot==''){
                  $acot=0;
                }

                $crud3 = new Crud();
                $crud3->setconsulta("select count(mc.id) as cot from cotizacion_maestro mc
                                    inner join estados es
                                    on es.id=mc.estado
                                    where estado=10 and fecha_cotizacion >= '$fecha'");
                $datos_usuario =  $crud3->seleccionar($con->getConnection());
                $rcot=$datos_usuario[0]['cot'];

                $crud4 = new Crud();
                $crud4->setconsulta("select count(id) as cot from usuario_detalle where registro >= '$fecha'");
                $datos_usuario =  $crud4->seleccionar($con->getConnection());
                $usun=$datos_usuario[0]['cot'];
                $con->desconectar();

                $pora=round(($acot/$tcot)*100);
                $porr=round(($rcot/$tcot)*100);
                if($stot==1){
                  $tcot=0;
                }

?>
  <div class="content-wrapper">
       <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $tcot ;?></h3>

              <p>Cotizaciones Mes</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <?php $acot=$acot.'('.$pora.'<sup style="font-size: 20px">%</sup>)' ?>
              <?php echo '<h3>'.$acot.'</h3>' ;?>

              <p>Cotizaciones Aprobadas (Mes)</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
                <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <?php $rcot=$rcot.'('.$porr.'<sup style="font-size: 20px">%</sup>)' ?>
              <?php echo '<h3>'.$rcot.'</h3>' ;?>


              <p>Cotizaciones Rechazadas (Mes)</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <?php echo '<h3>'.$usun.'</h3>' ;?>
              <p>Usuarios Nuevos</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

        <!-- ./col -->
      </div>
    </section>
  </div>