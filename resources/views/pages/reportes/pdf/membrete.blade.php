<div class="container-fluid"
    style="position: fixed; top: 0; left: 0; right: 0; background-color: #f2f2f2; padding: 10px;">
    <div class="row align-items-center">
        <!-- Logo Column -->
        <div class="col-6">
            <img src="{{ public_path('images/fish-222.png') }}" class="img-fluid" alt="Company Logo"
                style="max-width: 300px;">
        </div>

        <!-- Contact Information Column -->
        <div class="col-6 text-right">
            <h5>Company Name</h5>
            <p>Address Line 1<br>
                Address Line 2<br>
                Phone: (123) 456-7890<br>
                Email: info@company.com</p>
        </div>
    </div>
</div>

<div
    style="position: fixed; bottom: 0; left: 0; right: 0; height: 50px; background-color: #f2f2f2; padding: 10px; text-align: center;">
    <span style="font-weight: bold;">MEMBRETE INFERIOR</span>
</div>

<div
    style="position: absolute; top: 80px; bottom: 80px; left: 0; right: 0; padding-top: 100px; background-color: rgb(241, 241, 241);">
    @yield('content')
</div>
