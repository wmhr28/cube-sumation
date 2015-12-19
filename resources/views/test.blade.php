<html>
    <head>
        <title>Cube Summation</title>
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">        
        <link rel="stylesheet" href="{{ asset('/bootstrap/bootstrap.min.css') }}">
        <script src="{{ asset('/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('/bootstrap/bootstrap.min.js') }}"></script>

        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <script type="text/javascript">
        $(document).ready(function() {
            $("#div_operaciones").hide();
            $("#div_resultados").hide();
            $('#continuar').on('click', function(e) {

                $("#div_resultados").hide();
                var m = $('#M').val();
                var n = $('#N').val();

                if (n === '') {
                    alert('Ingrese el Tamaño de la matriz');
                    return;
                }
                if (n >= 100 && n <= 1) {
                    alert('El valor del campo Tamaño de la matriz esta fuera de rango');
                    return;
                }
                if (m === '') {
                    alert('Ingrese el Número de operaciones');
                    return;
                }
                if (m >= 1000 && m <= 1) {
                    alert('El valor del campo Número de operaciones esta fuera de rango');
                    return;
                }

                $('#myModal').modal("show");

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: "POST",
                    url: 'conf_operaciones',
                    data: {M: m, "_token": CSRF_TOKEN},
                    success: function(msg) {
                        $("#operaciones").html(msg);
                        $('#myModal').modal("hide");
                        $("#div_operaciones").show();
                        $("#id_op_1").focus();
                    }
                });

            });
            $('#calcular').on('click', function(e) {
                var n = $('#N').val();
                var ops = $('input[name="ops[]"]').serializeArray();
                $('#myModal').modal("show");

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: "POST",
                    url: 'resultado',
                    data: {N: n, "ops ": ops, "_token": CSRF_TOKEN},
                    success: function(msg) {
                        $("#resultados").html(msg);
                        $('#myModal').modal("hide");
                        $("#div_resultados").show();
                        $("#calcular").focus();
                    }
                });
            });
        });
        </script>

    </head>
    <body> 
        <div class="container">

            <div class="row">

                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">

                            <div class="modal-body">
                                <p>Cargando...</p>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Cube Summation / Test {{session('T_actual')}}</div>

                        <div class="panel-body">

                            <h2>Configuraci&oacute;n inicial</h2> 


                            <div class="form-group">
                                {!! Form::label('N','Tama&ntilde;o de la matriz')  !!}
                                {!! Form::number('N',null,['class'=>'form-control','required','min'=>'1','max'=>'100'])  !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('M','N&uacute;mero de operaciones')  !!} 
                                {!! Form::number('M',null,['class'=>'form-control','required','min'=>'1','max'=>'1000'])  !!}
                            </div>
                            <div class="form-group">                                
                                {!! Form::button('Continuar', ['class'=>'btn btn-primary form-control','id'=>'continuar'])  !!}
                            </div>

                            <div id="div_operaciones">
                                <hr>
                                <h2>Operaciones</h2> 
                                <div id="operaciones">

                                </div>
                                <div class="form-group">                                
                                    {!! Form::button('Calcular', ['class'=>'btn btn-primary form-control','id'=>'calcular'])  !!}
                                </div>
                            </div>

                            <div id="div_resultados">
                                <hr>
                                <h2>Resultados</h2> 
                                <div id="resultados">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
