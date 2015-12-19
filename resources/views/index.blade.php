<html>
    <head>
        <title>Cube Summation</title>
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">        
        <link rel="stylesheet" href="{{ asset('/bootstrap/bootstrap.min.css') }}">
        <script src="{{ asset('/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('/bootstrap/bootstrap.min.js') }}"></script> 
    </head>
    <body> 
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Cube Summation</div>

                        <div class="panel-body">
                            {!! Form::open(['url'=>'iniciarTest'])  !!}
                            <div class="form-group">
                                {!! Form::label('T','N&uacute;mero de pruebas')  !!}
                                {!! Form::number('T',null,['class'=>'form-control','required','min'=>'1','max'=>'50'])  !!}
                            </div>

                            <div class="form-group">                                
                                {!! Form::submit('Iniciar', ['id'=>'Iniciar','class'=>'btn btn-primary form-control'])  !!}
                            </div>
                            {!! Form::close()  !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>




