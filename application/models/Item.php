<?php
class Navo_Model_Item
{
    /**
     * @var Navo_Model_DbTable_Item
     */
    
    static public function getKeys() 
    {
        return array(
			"detail_url",		//商品url
        	"num_iid",		//商品数字id
        	"title",		//商品标题,不能超过60字节
// 		    "nick",		//卖家昵称
       		"type",		//商品类型(fixed:一口价;auction:拍卖)注：取消团购
// 		    "desc",		//商品描述, 字数要大于5个字符，小于25000个字符
// 		    "skus",		//Sku列表。fields中只设置sku可以返回Sku结构体中所有字段，如果设置为sku.sku_id、sku.properties、sku.quantity等形式就只会返回相应的字段
// 		    "props_name",		//商品属性名称。标识着props内容里面的pid和vid所对应的名称。格式为：pid1:vid1:pid_name1:vid_name1;pid2:vid2:pid_name2:vid_name2……(注：属性名称中的冒号":"被转换为："#cln#"; 分号";"被转换为："#scln#" )
       		"created",		//Item的发布时间，目前仅供taobao.item.add和taobao.item.get可用
// 		    "promoted_service",		//消保类型，多个类型以,分割。可取以下值： 2：假一赔三；4：7天无理由退换货；taobao.items.search和taobao.items.vip.search专用
// 		    "is_lightning_consignment",		//是否24小时闪电发货
// 		    "auction_point",		//商城返点比例，为5的倍数，最低0.5%
// 		    "property_alias",		//属性值别名,比如颜色的自定义名称
			"volume",		//对应搜索商品列表页的最近成交量,只有调用商品搜索:taobao.items.get和taobao.items.search的时候才能返回
// 		    "after_sale_id",		//售后服务ID,该字段仅在taobao.item.get接口中返回
			"is_xinpin",		//标示商品是否为新品。 值含义：true-是，false-否。
// 		    "inner_shop_auction_template_id",		//用户内店宝贝装修模板id
// 		    "outer_shop_auction_template_id",		//用户外店装修模板id
			"cid",		//商品所属的叶子类目 id
// 		    "seller_cids",		//商品所属的店铺内卖家自定义类目列表
// 		    "props",		//商品属性 格式：pid:vid;pid:vid
// 		    "input_pids",		//用户自行输入的类目属性ID串。结构："pid1,pid2,pid3"，如："20000"（表示品牌） 注：通常一个类目下用户可输入的关键属性不超过1个。
// 		    "input_str",		//用户自行输入的子属性名和属性值，结构:"父属性值;一级子属性名;一级子属性值;二级子属性名;自定义输入值,....",如：“耐克;耐克系列;科比系列;科比系列;2K5”，input_str需要与input_pids一一对应，注：通常一个类目下用户可输入的关键属性不超过1个。所有属性别名加起来不能超过 3999字节。
        	"pic_url",		//商品主图片地址
        	"num",		//商品数量
        	"valid_thru",		//有效期,7或者14（默认是14天）
        	"list_time",		//上架时间（格式：yyyy-MM-dd HH:mm:ss）
        	"delist_time",		//下架时间（格式：yyyy-MM-dd HH:mm:ss）
// 		    "stuff_status",		//商品新旧程度(全新:new，闲置:unused，二手：second)
// 		    "location",		//商品所在地
        	"price",		//商品价格，格式：5.00；单位：元；精确到：分
// 		    "post_fee",		//平邮费用,格式：5.00；单位：元；精确到：分
// 		    "express_fee",		//快递费用,格式：5.00；单位：元；精确到：分
// 		    "ems_fee",		//ems费用,格式：5.00；单位：元；精确到：分
// 		    "has_discount",		//支持会员打折,true/false
// 		    "freight_payer",		//运费承担方式,seller（卖家承担），buyer(买家承担）
// 		    "has_invoice",		//是否有发票,true/false
// 		    "has_warranty",		//是否有保修,true/false
        	"has_showcase",		//橱窗推荐,true/false
        	"modified",		//商品修改时间（格式：yyyy-MM-dd HH:mm:ss）
        	"approve_status",		//商品上传后的状态。onsale出售中，instock库中
// 		    "postage_id",		//宝贝所属的运费模板ID，如果没有返回则说明没有使用运费模板
// 		    "item_imgs",		//商品图片列表(包括主图)。fields中只设置item_img可以返回ItemImg结构体中所有字段，如果设置为item_img.id、item_img.url、item_img.position等形式就只会返回相应的字段
// 		    "prop_imgs",		//商品属性图片列表。fields中只设置prop_img可以返回PropImg结构体中所有字段，如果设置为prop_img.id、prop_img.url、prop_img.properties、prop_img.position等形式就只会返回相应的字段
// 		    "outer_id",		//商家外部编码(可与商家外部系统对接)
// 		    "is_virtual",		//虚拟商品的状态字段
// 		    "is_taobao",		//是否在淘宝显示
// 		    "is_ex",		//是否在外部网店显示
        	"is_timing",		//是否定时上架商品
// 		    "videos",		//商品视频列表(目前只支持单个视频关联)。fields中只设置video可以返回Video结构体中所有字段，如果设置为video.id、video.video_id、 video.url等形式就只会返回相应的字段
// 		    "is_3D",		//是否是3D淘宝的商品
// 		    "score",		//商品所属卖家的信用等级数，1表示1心，2表示2心……，只有调用商品搜索:taobao.items.get和taobao.items.search的时候才能返回
// 		    "one_station",		//是否淘1站商品
        	"second_kill",		//秒杀商品类型。打上秒杀标记的商品，用户只能下架并不能再上架，其他任何编辑或删除操作都不能进行。如果用户想取消秒杀标记，需要联系小二进行操作。如果秒杀结束需要自由编辑请联系活动负责人（小二）去掉秒杀标记。可选类型 web_only(只能通过web网络秒杀) wap_only(只能通过wap网络秒杀) web_and_wap(既能通过web秒杀也能通过wap秒杀)
// 		    "auto_fill",		//代充商品类型。只有少数类目下的商品可以标记上此字段，具体哪些类目可以上传可以通过taobao.itemcat.features.get获得。在代充商品的类目下，不传表示不标记商品类型（交易搜索中就不能通过标记搜到相关的交易了）。可选类型： time_card(点卡软件代充) fee_card(话费软件代充)
			"violation",		//商品是否违规，违规：true , 不违规：false
// 		    "is_prepay",		//商品是否为先行赔付 taobao.items.search和taobao.items.vip.search专用
// 		    "ww_status",		//商品所属的商家的旺旺在线状况， taobao.items.search和taobao.items.vip.search专用
// 		    "wap_desc",		//不带html标签的desc文本信息，该字段只在taobao.item.get接口中返回
// 		    "wap_detail_url",		//适合wap应用的商品详情url ，该字段只在taobao.item.get接口中返回
// 		    "cod_postage_id",		//货到付款运费模板ID
// 		    "sell_promise",		//是否承诺退换货服务!
        );
    }   
}
