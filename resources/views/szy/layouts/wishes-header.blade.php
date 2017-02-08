
<div class="wishes-header">
	<div class="top">
		<a href="{{url('')}}"><img src="{{App\Company::find(1)->logo}}" alt="" class="logo"></a>
		<div class="search">
			<input type="text" id="text_search" value="">
			<button type="button" onclick="search();">搜索</button>
		</div>
	</div>
</div>

@section('scripts')
	@parent
	<script type="text/javascript">
		//网站 商品搜索跳转
		function search(){
			window.location.href="products?search="+$("#text_search").val(); 
		}
	</script>
@stop