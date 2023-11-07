<template>
    <div>
	<div class="d-flex align-items-center justify-content-center vh-100 section-notfound">
		<div class="text-center">
			<h1 class="display-1 fw-bold">404</h1>
			<p class="fs-3"> <span class="text-danger">Lỗi!</span> Không tìm thấy trang</p>
			<p class="lead">
			Trang bạn đang tìm kiếm không tồn tại, đã bị xóa, được đổi tên hoặc tạm thời không có.
			</p>
			<router-link :to="{name:'clients-home'}" class="btn btn-success">Trở lại trang chủ</router-link>
		</div>
	</div>

    </div>

</template>

