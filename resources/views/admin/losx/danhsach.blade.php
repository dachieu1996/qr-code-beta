@extends('admin.layout.index')

@section('content')
    <<div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Danh Sách
                        <small>
                            <a href="admin/losanxuat/them" class="btn btn-default" target="_blank">Thêm dữ liệu</a>
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

                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr align="center">
                        <th>Mã Lô</th>
                        <th>Mã SP</th>
                        <th>Tên SP</th>
                        <th>SĐK</th>
                        <th>Hình ảnh</th>
                        <th>NSX</th>
                        <th>HSD</th>
                        <th>SL</th>
                        <th>Xem</th>
                        <th>Sửa</th>
                        <th>Xóa</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sp_losx as $sp)
                        <tr class="odd gradeX" align="center">
                            <td>{{$sp->MaLo}}</td>
                            <td>{{$sp->MaSP}}</td>
                            <td>{{$sp->motsanpham->TenSP}}</td>
                            <td>{{$sp->motsanpham->SDK}}</td>
                            <td>
                                <img width="100px" src="upload/sanpham/{{$sp->motsanpham->HinhAnh}}"/>
                            </td>
                            <td>{{$sp->NSX->format('d/m/Y')}}</td>
                            <td>{{$sp->HSD->format('d/m/Y')}}</td>
                            <td>{{$sp->SoLuong}}</td>

                            <td class="center"><i class="fa fa-info fa-fw"></i> <a href="admin/losanxuat/chitiet/{{$sp->MaLo}}/{{$sp->MaSP}}" target="_blank">Xem</a></td>
                            <td class="center"><i class="fa fa-wrench fa-fw"></i> <a href="admin/losanxuat/sua/{{$sp->MaLo}}/{{$sp->MaSP}}" target="_blank">Sửa</a></td>
                            <td class="center"><i class="fa fa-remove fa-fw"></i> <a href="admin/losanxuat/xoa/{{$sp->MaLo}}/{{$sp->MaSP}}">Xóa</a></td>
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
