@push('style')
    <!-- dropify -->
    <link rel="stylesheet" href="{{ asset('dropify/css/dropify.css') }}">
@endpush
<div class="qview-modal">
    <div class="prod-wrap">
        <a href="#">
            <h1 class="main-ttl">
                <span id="categoryText">Uplaod Struk Details</span>
            </h1>
        </a>
        <div class="prod-slider-wrap">
            <div class="cart-items-wrap">
                <table class="cart-items">
                    <thead>
                        <tr>
                            <td class="cart-ttl">INV</td>
                            <td class="cart-price">Price</td>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>

                            <td class="cart-ttl">
                                <a href="#" target="_blank" style="color: #7071E8" id="inv">#00000000</a>
                            </td>
                            <td class="cart-price">
                                <b id="price">00,000</b>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="prod-cont">
            <form action="" method="POST" enctype="multipart/form-data" id="formUpload">
                @csrf
                @method('PUT')
                <b>Struk Images:</b>
                <br>
                <br>
                <input type="file" class="dropify" name="foto" data-height="100" id="images" />

                <div class="prod-info" style="margin-top: 30px">
                    <p class="prod-addwrap">
                        <button type="submit" class="prod-add"><i class="fa fa-save  mr-2"></i>
                            Upload</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@push('script')
    {{-- dropify --}}
    <script src="{{ asset('dropify/js/dropify.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });
    </script>
    <script>
        $('.btnUpload').on('click', function() {
            $('#inv').html($(this).data('inv'));
            $('#price').html($(this).data('price'));
            $('#inv').attr('href', $(this).data('url'));
            const id = $(this).data('id');
            const url = `{{ url('upload-images/${id}') }}`;
            $('#formUpload').attr('action', url);
        })
    </script>
@endpush
