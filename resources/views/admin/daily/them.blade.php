@extends('admin.layout.index')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Đại lý
                        <small>Thêm</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-12" style="padding-bottom:120px">
                    <div class="col-lg-6">
                        <form action="admin/daily/them" method="POST">
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
                                <label>Mã Đại Lý</label>
                                <input class="form-control" name="MaDL" placeholder="Nhập mã đại lý" value="{{old('MaDL')}}" style="text-transform:uppercase"/>
                            </div>
                            <div class="form-group">
                                <label>Tên Đại Lý</label>
                                <input class="form-control" name="TenDL" placeholder="Nhập tên Đại Lý" value="{{old('TenDL')}}"/>
                            </div>
                            <button type="submit" class="btn btn-default">Thêm</button>
                        </form>
                    </div>
                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection

