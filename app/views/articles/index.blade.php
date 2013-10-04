@extends('layouts.master')

@section('head')
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script>
        (function($){

            $(document).on('ready', iniciar);

            function iniciar() {
                $('.pagination').addClass('btn-toolbar');
                $('.pagination ul').addClass('btn-group');
                $('.pagination ul li').addClass('btn btn-default');

                $('.tabs').tabs({ active: 1 });
            }

        })(jQuery);
    </script>

@stop

@section('content')

    <h1>
        Informe de Artículos
        {{ Form::open(array('url' => 'articles/search')) }}
            <div class="input-group">
              {{ Form::text('search', '', array('placeholder' => 'Buscar...', 'class' => 'form-control')) }}
              <span class="input-group-btn">
                <button class="btn btn-default" type="submit">Buscar</button>
              </span>
            </div><!-- /input-group -->
        {{ Form::close() }}
    </h1>

        @if(Session::has('filtro'))
            <div class="alert alert-dismissable alert-info">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{ Session::get('filtro') }}
            </div>
        @endif

    @foreach($articles as $article)

        <div class="panel panel-primary">
          <div class="panel-heading">
                <span class="glyphicon glyphicon-send"></span>
                {{ $article->name }}
          </div>
          <div class="panel-body">

            <div class="tabs">
              <ul>
                {{ '<li><a href="#tab1-'. $article->id .'"><span>Datos generales</span></a></li>' }}
                {{ '<li><a href="#tab2-'. $article->id .'"><span>Stock físico</span></a></li>' }}
              </ul>

              <div id="tab1-{{ $article->id }}">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Código</th>
                        <th>Medida</th>
                        <th>Precio</th>
                        <th>IVA</th>
                    </tr>
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td>{{ $article->unit }}</td>
                        <td>{{ $article->price }}</td>
                        <td>{{ $article->iva }}%</td>
                    </tr>
                </table>
                <p>{{ $article->comments }}</p>
              </div> <!-- /#tab1 -->

              <div id="tab2-{{ $article->id }}">
                <table class="table table-stripped table-hover">
                    <tr>
                        <th>Sucursal</th>
                        <th>Stock</th>
                    </tr>
                    @foreach($article->stocks as $stock)
                        <tr>
                            <td>{{ $stock->branch->name }}</td>
                            <td>{{ $stock->stock }}</td>
                        </tr>
                    @endforeach
                </table>
              </div> <!-- /#tab2 -->

            </div> <!-- /#tabs -->

          </div> <!-- /.panel-body -->

          <div class="panel-footer">
             {{ Form::open(array('url' => 'cart/add')) }}
                    {{ Form::text('id', $article->id, array('class' => 'hidden')) }}
                    {{ Form::input('number', 'cantidad', '1.00', array('class' => 'form-control', 'min' => '0.00', 'step' => '0.01', 'max' => '99999999999999.99', 'title' => 'Cantidad', 'required')) }}
                    <button type="submit" class="btn btn-success btn-sm">
                        <span class="glyphicon glyphicon-shopping-cart"></span>
                        Al carrito
                    </button>
                {{ Form::close() }}

                @if(Auth::check() && (Auth::user()->permitido('administrador') || Auth::user()->permitido('remisionero')))
                    {{ '<a href="'. url('articles/edit/'. $article->id) .'" class="btn btn-warning btn-sm">
                        <span class="glyphicon glyphicon-edit"></span>
                        Editar
                    </a>' }}
                @endif
          </div>
        </div> <!-- /.panel.panel-primary -->

    @endforeach

    <?php echo $articles->links(); ?>

@stop