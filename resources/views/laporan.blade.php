<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <h1>Venturo</h1>

    <div class="card">
        <div class="card-header">
          Laporan
        </div>
        <div class="card-body">
            <form action="{{url('laporan')}}" method="POST">
              @csrf
              @method('POST')
              <div class="row">
                <div class="col-6">
                  <select class="form-control" name="tahun" >
                      <option value="2021">2021</option>
                      <option value="2022">2022</option>
                  </select>
                </div>
                <input type="submit" value="Tampilkan" class="btn btn-primary col-3">
              </div>
            </form>

            @isset($men)     
              <div>
                <table class="table table-hover">
                  <tr>
                    <th rowspan="3">Menu</th>
                  </tr>
                  <tr>
                    <th colspan="13">Periode Pada {{$tahun}}</th>
                  </tr>
                  <tr>
                    <th>Jan</th>
                    <th>Feb</th>
                    <th>Mar</th>
                    <th>Apr</th>
                    <th>Mei</th>
                    <th>Jun</th>
                    <th>Jul</th>
                    <th>Aug</th>
                    <th>Sep</th>
                    <th>Okt</th>
                    <th>Nov</th>
                    <th>Des</th>
                    <th>Total</th>
                  </tr>
                  <tr class="table-dark">
                    <td>Makanan</td>
                  </tr>
                  @foreach ($men as $m)
                    @if ($m['kategori'] == 'makanan')
                  <tr>
                      <td>{{$m['menu']}}</td>
                      {{-- Perbulan Minuman--}}
                      @for ($i = 1; $i <= 12; $i++)                          
                        <?php 
                        $total = 0;
                        $total_permenu = 0;
                        ?>
                        @foreach ($laporan_perbulan as $l)
                          @if ($l['menu'] == $m['menu'])
                            <?php
                            $total_permenu += $l['total']
                            ?>
                          @endif
                          @if ($l['menu'] == $m['menu'] && $l['bulan'] == $i)
                            <?php
                            $total += $l['total']
                            ?>
                          @endif
                        @endforeach
                        <td>{{$total}}</td>
                      @endfor
                        <td>{{$total_permenu}}</td>
                  </tr>
                    @endif  
                  @endforeach
                  {{-- Minuman --}}
                  <tr class="table-dark">
                    <td>Minuman</td>
                  </tr>
                  @foreach ($men as $m)
                    @if ($m['kategori'] == 'minuman')
                      <tr>
                          <td>{{$m['menu']}}</td>
                          {{-- Perbulan Minuman--}}
                          @for ($i = 1; $i <= 12; $i++)                          
                            <?php
                            $total = 0;
                            $total_permenu = 0;
                            ?>
                            @foreach ($laporan_perbulan as $l) 
                              @if ($l['menu'] == $m['menu'])
                                <?php
                                $total_permenu += $l['total']
                                ?>
                              @endif
                              @if ($l['menu'] == $m['menu'] && $l['bulan'] == $i)
                                <?php
                                $total += $l['total']
                                ?>
                              @endif
                            @endforeach
                            <td>{{$total}}</td>
                          @endfor
                            <td>{{$total_permenu}}</td>
                      </tr>
                    @endif  
                  @endforeach
                      <tr>
                        <th>Total Perbulan</th>
                        <?php $total=0; $coba = [];?>
                        @foreach ($laporan_perbulan as $b) 
                        @for ($i = 1; $i <= 12; $i++)                            
                          @if ($b['bulan'] == $i)
                            <?php
                              $total += $b['total'];
                            ?>
                          @endif
                          {{-- <?php
                          ?> --}}
                          @endfor
                          <td>{{$total}}</td>
                          @endforeach
                      </tr>
                </table>
              </div>
            @endisset
        </div>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>