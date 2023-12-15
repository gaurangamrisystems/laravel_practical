<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Laravel Demo</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
		<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
		<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
		
	</head>
	<body>
		<nav class="navbar navbar-expand-lg bg-light">
			<div class="container">
				<div class="collapse navbar-collapse" id="navbarNavDropdown">
					<ul class="navbar-nav ms-auto">
						@guest
							<li class="nav-item">
								<a class="nav-link {{ (request()->is('login')) ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
							</li>
							<li class="nav-item">
								<a class="nav-link {{ (request()->is('register')) ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
							</li>
						@else    
							<li class="nav-item">
								<a class="nav-link {{ (request()->is('product')) ? 'active' : '' }}" href="{{ route('productlist') }}">Product Management</a>
							</li>
							<li class="nav-item">
								<a class="nav-link {{ (request()->is('customer')) ? 'active' : '' }}" href="{{ route('customerlist') }}">Contacts Management</a>
							</li>
							<li class="nav-item">
								<a class="nav-link {{ (request()->is('ticket')) ? 'active' : '' }}" href="{{ route('ticketlist') }}">Tickets Management</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
									{{ Auth::user()->name }}
								</a>
								<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="{{ route('logout') }}"
									onclick="event.preventDefault();
									document.getElementById('logout-form').submit();"
									>Logout</a>
									<form id="logout-form" action="{{ route('logout') }}" method="POST">
										@csrf
									</form>
								</li>
								</ul>
							</li>
						@endguest
					</ul>
				</div>
			</div>
		</nav>    
		<hr>
		<div class="container">
			@yield('content')
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>    
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
		@if(request()->segment(2) == "list")
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
			<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
			<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
		@endif
		@if(request()->segment(1) == "product")
			<script>
				var productListUrl="{{ url('api/products') }}";
				function deleteProduct(productId) {
					$(".productid").val(productId);
					$("#deleteModal").modal("show");
				}
			</script>
			<script src="{{ url('/assets/js/products.js')}}"></script>
		@endif
		@if(request()->segment(1) == "customer")
			<script>
				var customerListUrl="{{ url('api/customers') }}";
				function deleteContact(contactId) {
					$(".contactId").val(contactId);
					$("#deleteContactModal").modal("show");
				}
			</script>
			<script src="{{ url('/assets/js/customers.js')}}"></script>
		@endif
		@if(request()->segment(1) == "ticket")
			<script>
				var ticketListUrl="{{ url('api/tickets') }}";
				function deleteticket(ticketid) {
					$(".ticketid").val(ticketid);
					$("#deleteTicketModal").modal("show");
				}
			</script>
			<script src="{{ url('/assets/js/tickets.js')}}"></script>
		@endif
		<script>
			function validateInput(input) {
				// Remove leading zeros
				input.value = input.value.replace(/^0+/, '');

				// Ensure the input is non-negative
				if (input.value < 0) {
					input.setCustomValidity("Please enter a positive number");
				} else {
					input.setCustomValidity("");
				}
			}
		</script>
	</body>
</html>