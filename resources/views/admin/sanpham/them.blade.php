@extends('admin.layout.index')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Sản Phẩm
                        <small>Thêm</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-12" style="padding-bottom:120px">
                    <div class="col-lg-6">
                        <form action="admin/sanpham/them" enctype="multipart/form-data" method="POST">
                            @csrf
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
                                <label>Mã Sản Phẩm</label>
                                <input class="form-control" name="MaSP" placeholder="Nhập mã sản phẩm" value="{{old('MaSP')}}" style="text-transform:uppercase"/>
                            </div>
                            <div class="form-group">
                                <label>Tên Sản Phẩm</label>
                                <input class="form-control" name="TenSP" placeholder="Nhập tên sản phẩm" value="{{old('TenSP')}}"/>
                            </div>
                            <div class="form-group">
                                <label>Số Đăng Ký</label>
                                <input class="form-control" name="SDK" placeholder="Nhập số đăng ký" value="{{old('SDK')}}"/>
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh</label>
                                <input id="HinhAnh" type="file" onchange="readURL(this);" accept="image/*" class="form-control sanpham" name="HinhAnh" placeholder="Nhập hình ảnh" />
                            </div>
                            <button type="submit" class="btn btn-default">Thêm</button>
                        </form>

                    </div>
                    <div class="col-lg-6">
                        <div align="center">
                            <img id="imgHinhAnh" src="" width="400px" >
                        </div>
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
