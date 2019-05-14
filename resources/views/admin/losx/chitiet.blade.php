@extends('admin.layout.index')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Thông tin Lô sản xuất Sản Phẩm
                        <small></small>
                    </h1>
                </div>


                <div class="col-lg-12" style="padding-bottom:120px">
                    <div class="col-lg-6" >
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                        @if(session('thongbao'))
                            <div class="alert alert-success">
                                {{session('thongbao')}}
                            </div>
                        @endif
                        @if(session('canhbao'))
                            <div class="alert alert-warning">
                                {{session('canhbao')}}
                            </div>
                        @endif
                            <div class="form-group">
                                <label>Mã Lô:  </label>
                                <input class="form-control" name="MaLo" readonly value="{{$thongtin['MaLo']}}"/>
                            </div>
                            <div class="form-group">
                                <label>Mã Sản Phẩm:  </label>
                                <input class="form-control" name="MaSP" readonly value="{{$thongtin['MaSP']}}"/>
                            </div>
                            <div class="form-group">
                                <label>Tên Sản Phẩm: </label>
                                <input class="form-control" name="TenSP" readonly value="{{$thongtin['TenSP']}}" />
                            </div>
                            <div class="form-group">
                                <label>Số Đăng Ký: </label>
                                <input class="form-control" name="SDK" readonly value="{{$thongtin['SDK']}}"/>
                            </div>
                            <div class="form-group">
                                <label>Ngày Sản Xuất: </label>
                                <input class="form-control" name="NSX" readonly value="{{$thongtin['NSX']}}"/>
                            </div>
                            <div class="form-group">
                                <label>Hạn sử dụng: </label>
                                <input class="form-control" name="HSD" readonly value="{{$thongtin['HSD']}}"/>
                            </div>
                            <div class="form-group">
                                <label>Số lượng: </label>
                                <input class="form-control" name="SoLuong" readonly value="{{$thongtin['SoLuong']}}"/>
                            </div>
                    </div>
                    <div class="col-lg-6"style="padding-bottom:20px">
                        <div align="center">
                            <img id="imgHinhAnh" src="upload/sanpham/{{$thongtin['HinhAnh']}}" width="300px" >
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr align="center">
                                <th>Tên Đại lý</th>
                                <th>Số sản phẩm</th>
                            </tr>
                            </thead>
                            <tbody>
                            @for($i=0; $i<count($thongtin['MaDL']);$i++)
                                <input type="hidden" name="MaDL[]" value="{{$thongtin['MaDL'][$i]}}">
                                <input type="hidden" name="TenDL[]" value="{{$thongtin['TenDL'][$i]}}">
                                <input type="hidden" name="SoSP[]" value="{{$thongtin['SoSP'][$i]}}">
                                <tr class="odd gradeX" align="center">
                                    <td>{{$thongtin['TenDL'][$i]}}</td>
                                    <td>{{$thongtin['SoSP'][$i]}}</td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>

                </div>





            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#MaLo').keyup(function () {
                var MaLo = $(this).val();
                $.get("admin/ajax/TenSP/"+MaLo,function (data) {
                    $("#TenSP").html(data);
                })
            })
        })
    </script>
@endsection
