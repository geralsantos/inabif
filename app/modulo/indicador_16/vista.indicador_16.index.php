<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active"></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                        <strong>Formulario de Carga de Datos</strong>
                        </div>
                        <div class="card-body card-block">
                        <form enctype="multipart/form-data" class="form-horizontal" action="<?php echo $this->url("guardar"); ?>" method="POST">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="text-input" class=" form-control-label">Año</label>
                                    <select name="anio" id="anio" class="form-control">
                                        <option value="1">2018</option>
                                        <option value="2">2017</option>
                                        <option value="3">2016</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="text-input" class=" form-control-label">Mes</label>
                                    <select name="mes" id="mes" class="form-control">
                                        <option value="1">Enero</option>
                                        <option value="2">Febrero</option>
                                        <option value="3">Diciembre</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class=""><label for="text-input" class=" form-control-label">Sugerencias Respondidas</label><input type="number" id="sugerencias_respondidas" name="sugerencias_respondidas" placeholder="" class="form-control"> </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=""><label for="text-input" class=" form-control-label">Sugerencias Reportadas</label>
                                        <input type="number" id="sugerencias_reportadas" name="sugerencias_reportadas" placeholder="" class="form-control"> </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12 text-center" >
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-send"></i> Registrar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <strong>Gestión de Sugerencias y Felicitaciones</strong>
                    </div>
                    <div class="card-body card-block">
                        <div class="row form-group">
                            <div class="col col-md-1 col-sm-2">
                                <label for="select" class=" form-control-label">Año:</label>
                            </div>
                            <div class="col-12 col-md-2  col-sm-8">
                                <select name="select" id="select" class="form-control">
                                    <option value="1">2018</option>
                                    <option value="2">2017</option>
                                    <option value="3">2016</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <div id="lesly" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- .content -->