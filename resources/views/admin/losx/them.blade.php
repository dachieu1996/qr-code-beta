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

                <div class="col-lg-12" style="padding-bottom:120px">
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
                    <form action="admin/losanxuat/them" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Mã Lô</label>
                                <input id="MaLo" class="form-control" name="MaLo" placeholder="Nhập mã lô" value="{{old('MaLo')}}" required />
                            </div>
                            <div class="form-group">
                                <label>Mã Sản Phẩm</label>
                                <div id="error"></div>
                                <input id="MaSP" class="form-control" name="MaSP" placeholder="Nhập mã sản phẩm" value="{{old('MaSP')}}" style="text-transform:uppercase" required/>
                            </div>
                            <div class="form-group">
                                <label>Tên Sản Phẩm</label>
                                <input id="TenSP" class="form-control sanpham" name="TenSP" placeholder="Nhập tên sản phẩm" value="{{old('TenSP')}}" required/>
                            </div>
                            <div class="form-group">
                                <label>Số đăng ký</label>
                                <input id="SDK" class="form-control sanpham" name="SDK" placeholder="Nhập số đăng ký" value="{{old('SDK')}}" required/>
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh</label>
                                <input id="HinhAnh" type="file" onchange="readURL(this);" accept="image/*" class="form-control sanpham" name="HinhAnh" placeholder="Nhập hình ảnh" />
                            </div>
                            <div class="form-group">
                                <label>Ngày sản xuất</label>
                                <input id="NSX" class="form-control losx" type="date" name="NSX" placeholder="Nhập ngày sản xuất" value="{{old('NSX')}}" required />
                            </div>
                            <div class="form-group">
                                <label>Hạn sử dụng</label>
                                <input id="HSD" class="form-control losx" type="date" name="HSD" placeholder="Nhập hạn sử dụng" value="{{old('HSD')}}" required />
                            </div>
                            <div class="form-group">
                                <label>Số lượng</label>
                                <input id="SoLuong" class="form-control losx" type="number" name="SoLuong" placeholder="Nhập số lượng" value="{{old('SoLuong')}}" required/>
                            </div>
                        </div>

                        <div class="col-lg-6" style="padding-bottom: 20px">
                            <div align="center">
                                <img id="imgHinhAnh" src="" width="400px" >
                            </div>
                        </div>

                        <div class="col-lg-6" style="padding-bottom:120px">
                            <table  class="table table-striped table-bordered table-hover" id="tb">
                                <tr class="tr-header">
                                    <th>Đại Lý Phân Phối</th>
                                    <th>Số sản phẩm</th>
                                    <th><a href="javascript:void(0);" style="font-size:18px;" id="addMore" title="Add More Person"><span class="glyphicon glyphicon-plus"></span></a></th>
                                <tr>
                                    <td><select name="MaDL[]" class="form-control losx selectRound" required>
                                            <option></option>
                                            @foreach($daily as $dl)
                                                <option value="{{$dl->MaDL}}">{{$dl->TenDL}}</option>
                                            @endforeach
                                        </select></td>
                                    <td><input type="number" name="SoSP[]" class="form-control losx qty" size="10" required></td>


                                    <td><a href='javascript:void(0);'  class='remove'><span class='glyphicon glyphicon-remove'></span></a></td>
                                </tr>

                            </table>
                            <div class="form-group">
                                <label>Tổng số sản phẩm đã phân phối</label>
                                <input id='total' name="Tong" readonly class="form-control" />
                            </div>

                            <button id="btnsubmit" type="submit" class="btn btn-default" disabled>Thêm</button>
                        </div>

                    </form>

                </div>


            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection

@section('script')

    <script>
        $(function(){
            $('#addMore').on('click', function() {
                var data = $("#tb tr:eq(1)").clone(true).appendTo("#tb");
                data.find("input").val('');
            });
            $(document).on('click', '.remove', function() {
                var trIndex = $(this).closest("tr").index();
                if(trIndex>1) {
                    $(this).closest("tr").remove();
                } else {
                    alert("Không thể xóa hàng đầu tiên");
                }
            });
        });

        $(function(){
            $(document).on("change keyup", ".qty", function() {
                var sum = 0;
                $(".qty").each(function(){
                    sum += +$(this).val();
                });
                $("#total").val(sum);
                var total = $("#total").val();
                var SoLuong = $("#SoLuong").val();
                if (total == SoLuong && SoLuong != 0 && total != 0)
                    $("#btnsubmit").removeAttr("disabled");
                else
                    $("#btnsubmit").attr("disabled", true);
            });
        });

        $(document).on('change', '.selectRound', function(e) {
            var tralse = true;
            var selectRound_arr = []; // for contestant name
            $('.selectRound').each(function(k, v) {
                var getVal = $(v).val();
                //alert(getVal);
                if (getVal && $.trim(selectRound_arr.indexOf(getVal)) != -1) {
                    tralse = false;
                    //it should be if value 1 = value 1 then alert, and not those if -select- = -select-. how to avoid those -select-
                    alert('Đại lý đã được chọn. Hãy chọn đại lý khác');
                    $(v).val("");
                    return false;
                } else {
                    selectRound_arr.push($(v).val());
                }

            });
            if (!tralse) {
                return false;
            }
        });

        $("#SoLuong").keyup(function () {
            var total = $("#total").val();
            var SoLuong = $("#SoLuong").val();
            if (total == SoLuong && total != 0 && SoLuong!=0)
                $("#btnsubmit").removeAttr("disabled");
            else
                $("#btnsubmit").attr("disabled", true);
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


        $("#MaSP,#MaLo").change(function () {
            var MaSP = $("#MaSP").val();
            var MaLo = $("#MaLo").val();

            $("#txtMaSP").text("");
            $.ajax({
                type: 'GET',
                url: "admin/ajax/SanPham/"+MaSP,
                success: function(sp){
                    $("#TenSP").val(sp.TenSP);
                    $("#SDK").val(sp.SDK);
                    $("#imgHinhAnh").attr("src","upload/sanpham/"+sp.HinhAnh);
                    $(".sanpham").attr("readonly",true);
                },
                error: function(data){
                    //get the status code
                    $("#TenSP").val("");
                    $("#SDK").val("");
                    $("#imgHinhAnh").attr("src","");
                    $(".sanpham").removeAttr("readonly");
                },
            });
            $.ajax({
                type: 'GET',
                url: "admin/ajax/SP_LoSX/"+MaLo+"/"+MaSP,
                success: function(thongbao){
                    $("#error").html(thongbao);
                    $(".losx").attr("disabled",true);
                },
                error: function(thongbao){
                    //get the status code
                    $("#error").html(thongbao);
                    $(".losx").removeAttr("disabled");
                },
            });

        });

    </script>
@endsection
