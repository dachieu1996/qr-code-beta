@extends('admin.layout.index')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Thông tin về Sản phẩm</h1>
                </div>
                <!-- /.col-lg-12 -->

            </div>
            <div>



                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            {{$error}}<br>
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
                <div class="col-lg-12" style="padding-bottom:30px">
                    <form action="admin/sanpham" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Mã Sản Phẩm</label>
                                <input id="MaSP" class="form-control" name="MaSP" placeholder="Nhập mã sản phẩm" value="{{old('MaSP')}}" required/>
                            </div>
                            <div class="form-group">
                                <label>Tên Sản Phẩm</label>
                                <input id="TenSP" class="form-control" name="TenSP" placeholder="Nhập tên sản phẩm" value="{{old('TenSP')}}" required/>
                            </div>
                            <div class="form-group">
                                <label>Số đăng ký</label>
                                <input id="SDK" class="form-control" name="SDK" placeholder="Nhập số đăng ký" value="{{old('SDK')}}" required/>
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh</label>
                                <input id="HinhAnh" type="file" onchange="readURL(this);" accept="image/*" class="form-control" name="HinhAnh" placeholder="Nhập hình ảnh" />
                            </div>
                            <div class="form-group" style="padding-top:20px">
                                <button id="btnChonSP" type="submit" class="btn btn-default">Chọn Sản Phẩm</button>
                            </div>

                        </div>
                    </form>

                    <div class="col-lg-6">
                        <div align="center">
                            <img id="imgHinhAnh" src="" width="400px" >
                        </div>
                    </div>

                </div>

                <div class="col-lg-12">
                    <div class="col-lg-6" style="padding-bottom:120px">
                        <div class="form-group">
                            <label>Mã Lô</label>
                            <input class="form-control losx" name="MaLo" placeholder="Nhập mã lô" disabled />
                        </div>
                        <div class="form-group">
                            <label>Ngày sản xuất</label>
                            <input class="form-control losx" type="date" name="NSX" placeholder="Nhập ngày sản xuất" disabled />
                        </div>
                        <div class="form-group">
                            <label>Hạn sử dụng</label>
                            <input class="form-control losx" type="date" name="HSD" placeholder="Nhập hạn sử dụng" disabled />
                        </div>
                        <div class="form-group">
                            <label>Số lượng</label>
                            <input id="SoLuong losx" class="form-control" type="number" name="SoLuong" placeholder="Nhập số lượng" disabled />
                        </div>
                    </div>

                    <div class="col-lg-6" style="padding-bottom:120px">
                        <table  class="table table-striped table-bordered table-hover" id="tb">
                            <tr class="tr-header">
                                <th>Đại Lý Phân Phối</th>
                                <th>Số sản phẩm</th>
                                <th><a href="" style="font-size:18px;" id="addMore" title="Add More Person"><span class="glyphicon glyphicon-plus"></span></a></th>
                            <tr>
                                <td><select name="MaDL[]" class="form-control selectRound" disabled>
                                        <option></option>
                                    </select></td>
                                <td><input type="number" name="SoSP[]" class="form-control qty" size="10" disabled></td>
                                <td><a href=''  class='remove'><span class='glyphicon glyphicon-remove'></span></a></td>
                            </tr>

                        </table>
                        <div class="form-group">
                            <label>Tổng số sản phẩm đã phân phối</label>
                            <input id='total' name="Tong" readonly class="form-control" />
                        </div>

                        <button id="btnsubmit" type="submit" class="btn btn-default" disabled>Thêm</button>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script>


        $("#MaSP").keyup(function () {
            var MaSP = $("#MaSP").val();
            $.get("admin/ajax/SanPham/"+MaSP,function (data) {
                $("#TenSP").val(data.TenSP);
                $("#SDK").val(data.SDK);
                $("#imgHinhAnh").attr("src","upload/sanpham/"+data.HinhAnh);
            })
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#imgHinhAnh')
                        .attr('src', e.target.result)
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>
@endsection
