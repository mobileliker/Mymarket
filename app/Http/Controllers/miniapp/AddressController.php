<?php

namespace app\Http\Controllers\miniapp;

/*
 * Antvel - Company CMS Controller
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use App\User;
use App\OrderDetail;
use App\Order;
use DB;
use Illuminate\Http\Request;
use App\Product;
use App\Address;
use Redirect;



//商品数据
class AddressController extends Controller
{	
	//修改默认地址
	public function default($id,Request $request){

		$user_id = \Utility::openidUser($request);
		if ($user_id == 'false') {
			return response()->json('false');
		}

		$addressAlls = Address::where('user_id',$user_id)->select('id')->get();

		if (!empty($addressAlls)) {
			foreach ($addressAlls as $addressAll) {
				$new = Address::find($addressAll->id);
				$new->default = 0;
				$new->save();
			}
		}

		$address = Address::find($id);
		$address->default = 1;
		if ($address->save()) {
			$address = Address::where('user_id','=',$user_id)->get();
			return response()->json($address);
		}
		return response()->json('false');
	}

	//查询地址
	public function index(Request $request){

		$user_id = \Utility::openidUser($request);
		if ($user_id == 'false') {
			return response()->json('false');
		}

		$address = Address::where('user_id','=',$user_id)->get();
		return response()->json($address);

	}

	//加载修改的地址
	public function edit($id,Request $request){

		$user_id = \Utility::openidUser($request);
		if ($user_id == 'false') {
			return response()->json('false');
		}

		$address = Address::find($id);

		$array = ['--请选择--','北京市','天津市','上海市','重庆市','河北省','山西省','内蒙古自治区','辽宁省','吉林省','黑龙江省','江苏省','浙江省','安徽省','福建省','江西省','山东省','河南省','湖北省','湖南省','广东省','广西壮族自治区',"海南省","四川省","贵州省","云南省","西藏自治区","陕西省","甘肃省","宁夏回族自治区","青海省","新疆维吾尔族自治区","香港特别行政区","澳门特别行政区","台湾省"];
  		$array2 = [
		    [''],
		   ['--请选择--',"东城","西城","崇文","宣武","朝阳","丰台","石景山","海淀","门头沟","房山","通州","顺义","昌平","大兴","平谷","怀柔","密云","延庆"],
			 ['--请选择--',"黄浦","卢湾","徐汇","长宁","静安","普陀","闸北","虹口","杨浦","闵行","宝山","嘉定","浦东","金山","松江","青浦","南汇","奉贤","崇明"],
			 ['--请选择--',"和平","东丽","河东","西青","河西","津南","南开","北辰","河北","武清","红挢","塘沽","汉沽","大港","宁河","静海","宝坻","蓟县"],
			 ['--请选择--',"万州","涪陵","渝中","大渡口","江北","沙坪坝","九龙坡","南岸","北碚","万盛","双挢","渝北","巴南","黔江","长寿","綦江","潼南","铜梁 ","大足","荣昌","壁山","梁平","城口","丰都","垫江","武隆","忠县","开县","云阳","奉节","巫山","巫溪","石柱","秀山","酉阳","彭水","江津","合川","永川","南川"],
			 ['--请选择--',"石家庄","邯郸","邢台","保定","张家口","承德","廊坊","唐山","秦皇岛","沧州","衡水"],
			 ['--请选择--',"太原","大同","阳泉","长治","晋城","朔州","吕梁","忻州","晋中","临汾","运城"],
			 ['--请选择--',"呼和浩特","包头","乌海","赤峰","呼伦贝尔盟","阿拉善盟","哲里木盟","兴安盟","乌兰察布盟","锡林郭勒盟","巴彦淖尔盟","伊克昭盟"],
			 ['--请选择--',"沈阳","大连","鞍山","抚顺","本溪","丹东","锦州","营口","阜新","辽阳","盘锦","铁岭","朝阳","葫芦岛"],
			 ['--请选择--',"长春","吉林","四平","辽源","通化","白山","松原","白城","延边"],
			 ['--请选择--',"哈尔滨","齐齐哈尔","牡丹江","佳木斯","大庆","绥化","鹤岗","鸡西","黑河","双鸭山","伊春","七台河","大兴安岭"],
			 ['--请选择--',"南京","镇江","苏州","南通","扬州","盐城","徐州","连云港","常州","无锡","宿迁","泰州","淮安"],
			 ['--请选择--',"杭州","宁波","温州","嘉兴","湖州","绍兴","金华","衢州","舟山","台州","丽水"],
			 ['--请选择--',"合肥","芜湖","蚌埠","马鞍山","淮北","铜陵","安庆","黄山","滁州","宿州","池州","淮南","巢湖","阜阳","六安","宣城","亳州"],
			 ['--请选择--',"福州","厦门","莆田","三明","泉州","漳州","南平","龙岩","宁德"],
			 ['--请选择--',"南昌市","景德镇","九江","鹰潭","萍乡","新馀","赣州","吉安","宜春","抚州","上饶"],
			 ['--请选择--',"济南","青岛","淄博","枣庄","东营","烟台","潍坊","济宁","泰安","威海","日照","莱芜","临沂","德州","聊城","滨州","菏泽"],
			 ['--请选择--',"郑州","开封","洛阳","平顶山","安阳","鹤壁","新乡","焦作","濮阳","许昌","漯河","三门峡","南阳","商丘","信阳","周口","驻马店","济源"],
			 ['--请选择--',"武汉","宜昌","荆州","襄樊","黄石","荆门","黄冈","十堰","恩施","潜江","天门","仙桃","随州","咸宁","孝感","鄂州"],
			 ['--请选择--',"长沙","常德","株洲","湘潭","衡阳","岳阳","邵阳","益阳","娄底","怀化","郴州","永州","湘西","张家界"],
			 ['--请选择--',"广州","深圳","珠海","汕头","东莞","中山","佛山","韶关","江门","湛江","茂名","肇庆","惠州","梅州","汕尾","河源","阳江","清远","潮州","揭阳","云浮"],
			 ['--请选择--',"南宁","柳州","桂林","梧州","北海","防城港","钦州","贵港","玉林","南宁地区","柳州地区","贺州","百色","河池"],
			 ['--请选择--',"海口","三亚"],
			 ['--请选择--',"成都","绵阳","德阳","自贡","攀枝花","广元","内江","乐山","南充","宜宾","广安","达川","雅安","眉山","甘孜","凉山","泸州"],
			 ['--请选择--',"贵阳","六盘水","遵义","安顺","铜仁","黔西南","毕节","黔东南","黔南"],
			 ['--请选择--',"昆明","大理","曲靖","玉溪","昭通","楚雄","红河","文山","思茅","西双版纳","保山","德宏","丽江","怒江","迪庆","临沧"],
			 ['--请选择--',"拉萨","日喀则","山南","林芝","昌都","阿里","那曲"],
			 ['--请选择--',"西安","宝鸡","咸阳","铜川","渭南","延安","榆林","汉中","安康","商洛"],
			 ['--请选择--',"兰州","嘉峪关","金昌","白银","天水","酒泉","张掖","武威","定西","陇南","平凉","庆阳","临夏","甘南"],
			 ['--请选择--',"银川","石嘴山","吴忠","固原"],
			 ['--请选择--',"西宁","海东","海南","海北","黄南","玉树","果洛","海西"],
			 ['--请选择--',"乌鲁木齐","石河子","克拉玛依","伊犁","巴音郭勒","昌吉","克孜勒苏柯尔克孜","博尔塔拉","吐鲁番","哈密","喀什","和田","阿克苏"],
			 ['--请选择--',"香港特别行政区"],
			 ['--请选择--',"澳门特别行政区"],
			 ['--请选择--',"台北","高雄","台中","台南","屏东","南投","云林","新竹","彰化","苗栗","嘉义","花莲","桃园","宜兰","基隆","台东","金门","马祖","澎湖"]
		   ];
		$state = $city = 0;
		foreach ($array  as $key => $a) {
			if ($a==$address->state) {
				$state = $key;
			}
		}
		if ($state!=0) {
			foreach ($array2[$state]  as $k => $b) {
				if ($b==$address->city) {
					$city = $k;
				}
			}
		}

		$address->stateValue = $state;
		$address->cityValue = $city;
		return response()->json($address);
	}

	//保存地址
	public function store(Request $request){

		return $this->storeOrUpdate($request);
	}

	//保存修改
	public function update(Request $request){

		return $this->storeOrUpdate($request);
	}

	//修改新建保存方法
	public function storeOrUpdate($request){

		$user_id = \Utility::openidUser($request);
		if ($user_id == 'false') {
			return response()->json('false');
		}

		$id = -1;
		$aid = $request->input('id');
		if (!empty($aid) && $aid>-1) {
			$id = $aid;
		}

		$city = $request->input('city');
		$name = $request->input('name');
		$phone = $request->input('phone');
		$state = $request->input('state');
		$line1 = $request->input('line1');

		if ($id==-1) {
			$address = new Address;
			$address->default = 0;
		}else{
			$address = Address::find($id);
		}

		$address->city = $city;
		$address->user_id = $user_id;
		$address->name = $name;
		$address->phone = $phone;
		$address->state = $state;
		$address->line1 = $line1;

		if ($address->save()) {
			return response()->json('true');
		}
		return response()->json('false');
	}

	//删除单个地址接口
	public function destory($id,Request $request){

		$user_id = \Utility::openidUser($request);
		if ($user_id == 'false') {
			return response()->json('false');
		}

		$address = Address::find($id);
		if ($address->delete()) {
			return response()->json('true');
		}
		return response()->json('false');
	}
}
 