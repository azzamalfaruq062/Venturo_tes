<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <h1 class="text-center">Venturo</h1>

    <div class="card m-5">
        <div class="card-header">Laporan</div>
        <div class="card-body">
            <form action="{{url('laporan')}}" method="POST">
              @csrf
              @method('POST')
              <div class="row">
                <div class="col-3">
                  <select class="form-control" name="tahun" >
                      @isset($tahun)
                        <option value="{{$tahun}}" selected>{{$tahun}}</option>
                      @endisset
                      <option value="2021">2021</option>
                      <option value="2022">2022</option>
                  </select>
                </div>
                <input type="submit" value="Tampilkan" class="btn btn-primary col-1">
              </div>
            </form>
            @isset($men)     
              <div>
                <table class="table table-hover mt-3">
                  <tr>
                    <th rowspan="3" class="table-dark text-center text-light">Menu</th>
                  </tr>
                  <tr>
                    <th colspan="13" class="table-dark text-center text-light">Periode Pada {{$tahun}}</th>
                  </tr>
                  <tr class="text-light table-dark">
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
                    <td colspan="14" class="text-center">Makanan</td>
                  </tr>

                  @php
                  $az = 0;
                  @endphp

                  @foreach ($men as $m)
                    <?php $id = $az++; ?>
                    {{-- {{$az++}} --}}
                    {{-- Masih blom sempurna kesusahan dalam akses per row karena menu tidak ada id dan kesusahan nambahin id dalam json menu --}}
                    @if($m['kategori'] == 'makanan')
                      <tr>
                        <?php $menu = $m['menu']; ?>
                          <td>{{$m['menu']}}</td>
                          {{-- Perbulan, permenu Makanan--}}
                          @for ($i = 1; $i <= 12; $i++)                          
                            <?php $total = 0; $total_permenu = 0; ?>
                            @foreach ($laporan_perbulan as $l)
                              <?php $menuu = $m['menu'] ?>
                              @if ($l['menu'] == $m['menu'])
                                <?php $total_permenu += $l['total'] ?>
                                  @if ($l['bulan'] == $i)
                                    <?php $total += $l['total'] ?>
                                  @endif
                              @endif
                              @endforeach
                              {{-- Modal --}}
                              <div class="modal fade" id="index_{{$i}}_{{$id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="menu" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h1 class="modal-title fs-5" id="staticBackdropLabel">Laporan Penjualan {{$menu}}</h1>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      @foreach ($laporan_perbulan as $lap)
                                          @if ($lap['bulan'] == $i && $lap['menu'] == $menu)
                                          <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                {{$lap['tanggal'] }} :
                                                {{ number_format($lap['total'], 0, ',', '.') }}
                                            </li>
                                          </ul>
                                          @endif
                                      @endforeach
                                      Menu : {{$menu}}<br>Total : {{number_format($total)}}<br>Bulan : 0{{$i}}
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              {{-- And Modal --}}

                            <td data-bs-toggle="modal" data-bs-target="#index_{{$i}}_{{$id}}"> {{number_format($total)}}</td>
                          @endfor
                          <td>{{number_format($total_permenu)}}</td>
                      </tr>
                    @endif 

                  @endforeach

                  {{-- Minuman --}}
                  <tr class="table-dark">
                    <td colspan="14" class="text-center">Minuman</td>
                  </tr>
                  @foreach ($men as $m)
                  <?php $id = $az++; ?>
                    @if ($m['kategori'] == 'minuman')
                      <tr>
                        <?php $menu = $m['menu']; ?>
                          <td>{{$m['menu']}}</td>
                          @for ($i = 1; $i <= 12; $i++)                          
                            <?php $total = 0; $total_permenu = 0; ?>
                            @foreach ($laporan_perbulan as $l) 
                              @if ($l['menu'] == $m['menu'])
                                <?php $total_permenu += $l['total'] ?>
                                  @if ($l['bulan'] == $i)
                                    <?php $total += $l['total'] ?>
                                  @endif
                              @endif
                            @endforeach
                              {{-- Modal --}}
                              <div class="modal fade" id="minum_{{$i}}_{{$az}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="menu" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h1 class="modal-title fs-5" id="staticBackdropLabel">Laporan Penjualan {{$menu}}</h1>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      @foreach ($laporan_perbulan as $lap)
                                          @if ($lap['bulan'] == $i && $lap['menu'] == $menu)
                                          <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                {{$lap['tanggal'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                {{ number_format($lap['total'], 0, ',', '.') }}
                                            </li>
                                          </ul>
                                          @endif
                                      @endforeach
                                      Menu : {{$menu}}<br>Total : {{number_format($total)}}<br>Bulan : 0{{$i}}
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              {{-- And Modal --}}
                          <td data-bs-toggle="modal" data-bs-target="#minum_{{$i}}_{{$az}}"> {{number_format($total)}}</td>
                          {{-- <td>{{$total}}</td> --}}
                          @endfor
                          <td>{{number_format($total_permenu)}}</td>
                      </tr>
                    @endif  
                  @endforeach
                      <tr>
                        <th>Total Perbulan</th>
                        <td>{{$januari}}</td>
                        <td>{{$februari}}</td>
                        <td>{{$maret}}</td>
                        <td>{{$april}}</td>
                        <td>{{$mei}}</td>
                        <td>{{$juni}}</td>
                        <td>{{$juli}}</td>
                        <td>{{$agustus}}</td>
                        <td>{{$september}}</td>
                        <td>{{$oktober}}</td>
                        <td>{{$november}}</td>
                        <td>{{$desember}}</td>
                        <?php $total_semua = 0; ?>
                        @foreach ($laporan_perbulan as $l)
                          <?php $total_semua += $l['total'] ?>
                        @endforeach
                        <td>{{$total_semua}}</td>
                      </tr>
                </table>
              </div>
            @endisset
        </div>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>