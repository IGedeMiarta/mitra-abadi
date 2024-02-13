@extends('dashboard.partials.app')
@push('style')
    <!-- page css -->
    <link href="{{ asset('app') }}/assets/vendors/datatables/dataTables.bootstrap.min.css" rel="stylesheet">
    <!-- Select 2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- dropify -->
    <link rel="stylesheet" href="{{ asset('dropify/css/dropify.css') }}">
@endpush
@section('content')
    <button class="btn btn-success mb-3 text-end" data-toggle="modal" data-target="#modalAdd"><i
            class="anticon anticon-plus-square mr-2"></i>Add
        {{ $title }}</button>

    <div class="card">
        <div class="card-body">
            <h4>All {{ $title ?? '' }}</h4>
            <div>
                <div class="table-responsive">
                    <table id="data-table" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th class="text-center">Outer Size <span class="small">(mm)</span></th>
                                <th class="text-center">Inner Size <span class="small">(mm)</span></th>
                                <th class="text-center">Weight <span class="small">(kg)</span></th>
                                <th class="text-center">Stock</span></th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($table as $t)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        <img src="{{ url($t->images) }}" alt="{{ $t->product_slug }}"
                                            style="max-width: 100px">

                                    </td>
                                    <td>{{ $t->product_name }}</td>
                                    <td>{{ $t->brand->name }}</td>
                                    <td>{{ $t->category->category_name }}</td>
                                    <td>{{ $t->in_size }}</td>
                                    <td>{{ $t->out_size }}</td>
                                    <td>{{ $t->weight }}</td>
                                    <td>{{ $t->stock }}</td>
                                    <td>{{ number_format($t->price, 0, '.', ',') }}</td>
                                    <td>
                                        @if ($t->status)
                                            <span class="badge badge-success">ACTIVE</span>
                                        @else
                                            <span class="badge badge-danger">NONACTIVE</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <form action="{{ url('admin/products', $t->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-info btn-sm mb-2 btnSee"
                                                data-id="{{ $t->id }}" data-details="{{ $t->description }}"
                                                data-slug="{{ $t->product_slug }}" data-name="{{ $t->product_name }}"
                                                data-image="{{ url($t->images) }}" data-brand="{{ $t->brand->name }}"
                                                data-in_size="{{ $t->in_size }}" data-out_size="{{ $t->out_size }}"
                                                data-weight="{{ $t->weight }}"
                                                data-price="{{ number_format($t->price, 0, '.', ',') }}">
                                                <i class="anticon anticon-eye mr-2"></i>
                                                See
                                            </button>
                                            <button class="btn btn-warning btn-sm btnEdit mb-2"
                                                data-url="{{ url('admin/products', $t->id) }}"
                                                data-id="{{ $t->id }}" data-details="{{ $t->description }}"
                                                data-slug="{{ $t->product_slug }}" data-name="{{ $t->product_name }}"
                                                data-image="{{ url($t->images) }}" data-in_size="{{ $t->in_size }}"
                                                data-brand="{{ $t->brand_id }}" data-out_size="{{ $t->out_size }}"
                                                data-category="{{ $t->id_category }}" data-weight="{{ $t->weight }}"
                                                data-price="{{ number_format($t->price, 0, '.', ',') }}"
                                                data-status="{{ $t->status }}"><i class="anticon anticon-edit mr-2"></i>
                                                Edit</button>
                                            <button type="submit" class="btn btn-danger btn-sm mb-2"><i
                                                    class="anticon anticon-delete mr-2"></i>Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Add-->
    <div class="modal fade" id="modalAdd">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add {{ $title }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('product_name') is-invalid @enderror"
                                    name="product_name" placeholder="Product Name" value="{{ old('product_name') }}">
                                @error('product_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Category</label>
                            <div class="col-sm-9">
                                <select class="select2 form-control @error('category') is-invalid @enderror"
                                    name="category">
                                    <option value="">- Select Category</option>
                                    @foreach ($category as $c)
                                        <option value="{{ $c->id }}"
                                            @if (old('category')) selected @endif>
                                            {{ $c->category_name }}</option>
                                    @endforeach
                                </select>

                                @error('category')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Brand</label>
                            <div class="col-sm-9">
                                <select class="select2-tags form-control brand  @error('brand') is-invalid @enderror"
                                    name="brand">
                                    <option value="">- Select Brand</option>
                                    @foreach ($brand as $au)
                                        <option value="{{ $au->id }}">{{ $au->name }}</option>
                                    @endforeach
                                </select>
                                @error('brand')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Inner Size <span
                                    class="small text-primary">(mm)</span></label>
                            <div class="col-sm-9">
                                <input type="string"
                                    class="form-control @error('brand')
                                    is-invalid
                                @enderror"
                                    name="in_size" placeholder="00 x 00 x 00">
                                @error('brand')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Outer Size <span
                                    class="small text-primary">(mm)</span></label>
                            <div class="col-sm-9">
                                <input type="string"
                                    class="form-control  @error('out_size')
                                    is-invalid
                                @enderror"
                                    name="out_size" placeholder="00 x 00 x 00">
                                @error('out_size')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Wight <span
                                    class="small text-primary">(Kg)</span></label>
                            <div class="col-sm-9">
                                <input type="numbers"
                                    class="form-control inpNumber @error('out_size')
                                    is-invalid
                                @enderror"
                                    name="weight" placeholder="00">
                                @error('weight')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Price</label>
                            <div class="col-sm-9">
                                <input type="numbers"
                                    class="form-control inpNumber @error('price')
                                    is-invalid
                                @enderror"
                                    name="price" placeholder="00,000">
                                @error('weight')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Desciption</label>
                            <div class="col-sm-9">
                                <textarea name="description"
                                    class="form-control @error('description')
                                    is-invalid
                                @enderror"
                                    id="" cols="30" rows="5"></textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Images
                            </label>
                            <div class="col-sm-9">
                                <input type="file" class="dropify is-invalid" name="image" data-height="100" />
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Stock</label>
                            <div class="col-sm-9">
                                <input type="numbers"
                                    class="form-control inpNumber @error('stock')
                                    is-invalid
                                @enderror"
                                    name="stock" placeholder="00">
                                @error('stock')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Edit-->
    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit {{ $title }}</h5>
                    <button type="button" class="close" onclick="hideEditModal()" data-dismiss="modal">
                        <i class="anticon anticon-close" class="close"></i>
                    </button>
                </div>
                <form action="" method="POST" id="updateForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="product_name" id="product_name"
                                    placeholder="Product Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Category</label>
                            <div class="col-sm-9">
                                <select class="select2 form-control" name="category" id="category">
                                    <option disabled>- Select Category</option>
                                    @foreach ($category as $c)
                                        <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Brand</label>
                            <div class="col-sm-9">
                                <select class="select2-tags form-control form-control brand" id="brand"
                                    name="brand">
                                    <option disabled>- Select Brand</option>
                                    @foreach ($brand as $au)
                                        <option value="{{ $au->id }}">{{ $au->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Inner Size <span
                                    class="small text-primary">(mm)</span></label>
                            <div class="col-sm-9">
                                <input type="string" class="form-control" name="in_size" id="in_size"
                                    placeholder="00 x 00 x 00">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Outer Size <span
                                    class="small text-primary">(mm)</span></label>
                            <div class="col-sm-9">
                                <input type="string" class="form-control" name="out_size" id="out_size"
                                    placeholder="00 x 00 x 00">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Wight <span
                                    class="small text-primary">(Kg)</span></label>
                            <div class="col-sm-9">
                                <input type="numbers" class="form-control inpNumber" name="weight" id="weight"
                                    placeholder="00">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Price</label>
                            <div class="col-sm-9">
                                <input type="numbers" class="form-control inpNumber" name="price" id="price"
                                    placeholder="00,000">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Desciption</label>
                            <div class="col-sm-9">
                                <textarea name="description" class="form-control" id="description" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select class="select2-tags form-select form-control" name="status" id="status">
                                    <option disabled>- Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">NonActive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Images
                            </label>
                            <div class="col-sm-9">
                                <input type="file" class="dropify" name="foto" data-height="100"
                                    id="images" />
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal See-->
    <div class="modal fade" id="modalSee">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Details Product</h5>
                    <button type="button" class="close" data-dismiss="modal" onclick="hideSeeModal()"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-6">
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner" id="imageCarousel">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 id="productName" class="productName">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Placeat, cum.</h3>
                        <div class="prod-info row">
                            <div class="col-md-12">
                                <p class="prod-skuttl">Brand</p>
                                <a href="#" id="authorUrl">
                                    <h3 class="item_current_price badge badge-dark authorName"
                                        style="background-color: blue; border-radius: 0%" id="authorName">BrandName</h3>
                                </a>
                            </div>
                        </div>
                        <div class="prod-info row mb-3">
                            <div class="col-lg-4 col-md-12 col-sm-12">
                                <p class="prod-skuttl">Inner Size</p>
                                <h3 class="item_current_price badge badge-primary in_size"
                                    style="background-color: gray; border-radius: 0%" id="">
                                    0x0x0 mm</h3>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12">
                                <p class="prod-skuttl">Outer Size</p>
                                <h3 class="item_current_price badge badge-primary out_size"
                                    style="background-color: gray; border-radius: 0%" id="">
                                    0x0x0 mm</h3>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12">
                                <p class="prod-skuttl">Wight</p>
                                <h3 class="item_current_price badge badge-primary weight"
                                    style="background-color: gray; border-radius: 0%" id="weight">
                                    00 Kg</h3>
                            </div>
                        </div>
                        <div class="tags mt-2">
                            <h3 class="text-secondary text-end price" id="price">Rp 50.000</h3>
                        </div>
                        <div class="tags mt-2">
                            <span id="details" class="details">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Ipsa laudantium
                                officiis ea. Eius
                                omnis recusandae provident dolore! Adipisci at, quaerat temporibus aspernatur numquam
                                necessitatibus consequuntur saepe voluptates, enim quo qui recusandae doloribus quas beatae,
                                officiis assumenda. Deleniti ipsum veritatis, sapiente impedit deserunt id! Enim commodi
                                officiis ducimus fugit non vel!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <!-- page js -->
    <script src="{{ asset('app') }}/assets/vendors/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('app') }}/assets/vendors/datatables/dataTables.bootstrap.min.js"></script>
    {{-- select 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- dropify --}}
    <script src="{{ asset('dropify/js/dropify.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();

            $('.select2').select2({
                theme: 'bootstrap-5'
            });
            $('.brand').select2({
                tags: true,
                theme: 'bootstrap-5'
            });
            $('#tags').select2({
                tags: true,
                theme: 'bootstrap-5'
            });


        });
    </script>

    <script>
        $('.close').on('click', function() {
            $(this).modal('hide');
        })

        function hideEditModal() {
            $('#modalEdit').modal('hide');
        }

        function hideSeeModal() {
            $('#modalSee').modal('hide');
        }
        $('#data-table').DataTable();
        $('.btnEdit').on('click', function(e) {
            e.preventDefault();
            const url = $(this).data('url');
            const id = $(this).data('id');
            const name = $(this).data('name');
            const slug = $(this).data('slug');
            const price = $(this).data('price');
            var details = $(this).data('details');
            const image = $(this).data('image');
            const brand = $(this).data('brand');
            const in_size = $(this).data('in_size');
            const out_size = $(this).data('out_size');
            const weight = $(this).data('weight');

            $('#product_name').val(name);
            $('#category').val($(this).data('category'));
            $('#brand').val(brand);
            $('#in_size').val(in_size);
            $('#out_size').val(out_size);
            $('#weight').val(weight);
            $('#price').val(price);
            $('#description').val(details)
            $('#status').val($(this).data('status'))
            $('#images').attr('data-default-file', image);
            $('.dropify').dropify();
            $('#modalEdit').modal('show');
            $('#name').val(name);
            $('#updateForm').attr('action', `${url}`);
        })
        $('.btnSee').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const slug = $(this).data('slug');
            const price = $(this).data('price');
            console.log(price);
            const tag = $(this).data('tag');
            var details = $(this).data('details');
            const image = $(this).data('image');
            const brand = $(this).data('brand');
            const in_size = $(this).data('in_size');
            const out_size = $(this).data('out_size');
            const weight = $(this).data('weight');
            details = details.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            details = details.replace(/\n/g, '<br>');

            $('.productName').text(name);
            $('.Tags').append(tag);
            $('.price').text('Rp ' + price);
            $('.details').text(details);
            $('.authorName').text(brand);
            $('.in_size').text(in_size + ' mm');
            $('.out_size').text(out_size + ' mm');
            $('.weight').text(weight + ' kg');
            let slide = ''
            slide += `<div class="carousel-item active">`;
            slide += `<img src="${image}" class="d-block w-100" alt="image">`
            slide += '</div>';
            $('#imageCarousel').html(slide);

            $('#modalSee').modal('show');
        })
    </script>
@endpush
