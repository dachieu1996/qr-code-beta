@extends('admin.layout.index')

@section('content')
    <<div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Sản Phẩm
                        <small>Danh Sách</small>
                        <small>
                            <a href="admin/sanpham/them" class="btn btn-default" target="_blank">Thêm dữ liệu</a>
                        </small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->

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
                @if(session('nguyhiem'))
                    <div class="alert alert-danger">
                        {{session('nguyhiem')}}
                    </div>
                @endif

                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr align="center">
                        <th>Mã SP</th>
                        <th>Tên</th>
                        <th>SĐK</th>
                        <th>Hình ảnh</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sanpham as $sp)
                        <tr class="odd gradeX" align="center">
                            <td>{{$sp->MaSP}}</td>
                            <td>{{$sp->TenSP}}</td>
                            <td>{{$sp->SDK}}</td>
                            <td>
                                <img width="100px" src="upload/sanpham/{{$sp->HinhAnh}}"/>
                            </td>
                            <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/sanpham/sua/{{$sp->MaSP}}" target="_blank">Sửa</a></td>
                            <td class="center"><i class="fa fa-remove fa-fw"></i> <a href="admin/sanpham/xoa/{{$sp->MaSP}}">Xóa</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
