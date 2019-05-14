@extends('admin.layout.index')

@section('content')
    <<div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Đại lý
                        <small>Danh Sách</small>
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
                        <th>Mã Đại Lý</th>
                        <th>Tên Đại Lý</th>
                        <th>Sửa</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($daily as $dl)
                        <tr class="odd gradeX" align="center">
                            <td>{{$dl->MaDL}}</td>
                            <td>{{$dl->TenDL}}</td>
                            <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/daily/sua/{{$dl->MaDL}}" target="_blank">Sửa</a></td>
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
