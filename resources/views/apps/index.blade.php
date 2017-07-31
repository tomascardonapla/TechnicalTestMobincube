<!DOCTYPE html>
<html>
    <head>
        <title>Apps</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    </head>
    
    <body id="apps">
        <div class="container">
            <h1>Apps</h1>
            @if (count($apps) > 0)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width:10% !important;">Id</th>
                            <th style="width:60% !important;">Name</th>
                            <th style="width:20% !important;">Main Screen</th>
                            <th style="width:10% !important;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($apps as $app)
                            <tr>
                                <td> {{ $app->id }} </td>
                                <td> {{ $app->name }} </td>
                                <td> {{ $app->mainScreen }} </td>
                                <td><button id="btn-toxml" class="btn btn-primary btn-xs" onclick="app.toXml({{ $app->id }})"><span class="glyphicon glyphicon-save"> </span> To XML</button> </td>

                            </tr>
                       @endforeach
                   </tbody>
                </table>  
            @else
                <div class="title">Lo siento pero no hay aplicaciones</div>
            @endif                
        </div>
    
        <script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
              crossorigin="anonymous"></script>

        <script>
            var app = {
                toXml : function (idApp) {
                    var location = window.location;

                    var url = location + '/app/' + idApp + '/xml';

                    //var url = 'http://localhost/mobincube-laravel/public/apps/app/' + idApp + '/xml';
                    //var url = 'http://www.tomascardonapla.com/mobincube/public/apps/' + idApp;
                    $.ajax({
                        type: "GET",
                        url: url,
                        success: (function(data, status){
                            xml = $.trim(data);
                            setTimeout(function() {
                                window.open(xml);
                            }, 100);
                        }),
                        error: (function(){
                            alert ("Error al procesar: toXml");
                        })
                    });
                },
            };
        </script>

    </body>


</html>
