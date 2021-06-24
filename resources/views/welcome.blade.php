<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Coalition</title>
    @include("layouts.head")
</head>

<body>

<div class="col-lg-8 mx-auto p-3 py-md-5">
    <header class="d-flex align-items-center pb-3 mb-5 border-bottom">
        <h4>Product Page</h4>
    </header>
    <main>
        <div>
            <div class="mb-3">
                <label for="productName" class="form-label">Product Name</label>
                <input required type="email" class="form-control" id="productName" placeholder="Enter Product Name">
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity in Stock</label>
                <input required type="number" class="form-control" id="quantity"
                       placeholder="Enter Stock Quantity">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price per item</label>
                <input required type="number" class="form-control" id="price" placeholder="Enter Price">
            </div>
            <div class="mb-3">
                <button onclick="submit();" class="btn btn-primary">Create</button>
            </div>
        </div>
        <div class="list-group">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">S/N</th>
                    <th scope="col">Product name</th>
                    <th scope="col">Quantity in stock</th>
                    <th scope="col">Price per item</th>
                    <th scope="col">Datetime submitted</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $product["product_name"] }}</td>
                        <td>{{ $product["product_quantity"] }}</td>
                        <td>{{ $product["product_price"] }}</td>
                        <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($product["created_at"]))->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No Products</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3" class="table-active font-weight-bold">Total Value Number</td>
                    <td>{{ array_sum(array_column($products, "product_total")) }}</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </main>
</div>

<script>
    function submit() {
        let product_name = $('#productName').val();
        let quantity = $('#quantity').val();
        let price = $('#price').val();

        $.ajax({
            url: "{{ route("create.product") }}",
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "product_name": product_name,
                "product_quantity": quantity,
                "product_price": price
            },
            success: function (response) {

            }
        });
    }
</script>
</body>

</html>

