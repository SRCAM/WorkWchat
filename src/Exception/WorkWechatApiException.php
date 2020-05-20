<?php


namespace WorkWechat\Exception;


class WorkWechatApiException extends \Exception
{
    public function __construct($code)
    {
        $this->code = $code;
        $this->message = isset($this->error[$code]) ? $this->error[$code] : '未知错误';
    }

    private $error = array(
        '40001' => '不合法的secret参数',
        '40003' => '无效的UserID',
        '40004' => '不合法的媒体文件类型',
        '40005' => '不合法的type参数',
        '40006' => '不合法的文件大小',
        '40007' => '不合法的media_id参数',
        '40008' => '不合法的msgtype参数',
        '40009' => '上传图片大小不是有效值',
        '40011' => '上传视频大小不是有效值',
        '40013' => '不合法的CorpID',
        '40014' => '不合法的access_token',
        '40016' => '不合法的按钮个数',
        '40017' => '不合法的按钮类型',
        '40018' => '不合法的按钮名字长度',
        '40019' => '不合法的按钮KEY长度',
        '40020' => '不合法的按钮URL长度',
        '40022' => '不合法的子菜单级数',
        '40023' => '不合法的子菜单按钮个数',
        '40024' => '不合法的子菜单按钮类型',
        '40025' => '不合法的子菜单按钮名字长度',
        '40026' => '不合法的子菜单按钮KEY长度',
        '40027' => '不合法的子菜单按钮URL长度',
        '40029' => '不合法的oauth_code',
        '40031' => '不合法的UserID列表',
        '40032' => '不合法的UserID列表长度',
        '40033' => '不合法的请求字符',
        '40035' => '不合法的参数',
        '40039' => '不合法的url长度',
        '40050' => 'chatid不存在',
        '40054' => '不合法的子菜单url域名',
        '40055' => '不合法的菜单url域名',
        '40056' => '不合法的agentid',
        '40057' => '不合法的callbackurl或者callbackurl验证失败',
        '40058' => '不合法的参数',
        '40059' => '不合法的上报地理位置标志位',
        '40063' => '参数为空',
        '40066' => '不合法的部门列表',
        '40068' => '不合法的标签ID',
        '40070' => '指定的标签范围结点全部无效',
        '40071' => '不合法的标签名字',
        '40072' => '不合法的标签名字长度',
        '40073' => '不合法的openid',
        '40074' => 'news消息不支持保密消息类型',
        '40077' => '不合法的pre_auth_code参数',
        '40078' => '不合法的auth_code参数',
        '40080' => '不合法的suite_secret',
        '40082' => '不合法的suite_token',
        '40083' => '不合法的suite_id',
        '40084' => '不合法的permanent_code参数',
        '40085' => '不合法的的suite_ticket参数',
        '40086' => '不合法的第三方应用appid',
        '40088' => 'jobid不存在',
        '40089' => '批量任务的结果已清理',
        '40091' => 'secret不合法',
        '40092' => '导入文件存在不合法的内容',
        '40093' => '不合法的jsapi_ticket参数',
        '40094' => '不合法的URL',
        '40096' => '不合法的外部联系人userid',
        '40097' => '该成员尚未离职',
        '40098' => '接替成员尚未实名认证',
        '40099' => '接替成员的外部联系人数量已达上限',
        '40100' => '此用户的外部联系人已经在转移流程中',
        '40102' => '域名或IP不可与应用市场上架应用重复',
        '41001' => '缺少access_token参数',
        '41002' => '缺少corpid参数',
        '41004' => '缺少secret参数',
        '41006' => '缺少media_id参数',
        '41008' => '缺少auth code参数',
        '41009' => '缺少userid参数',
        '41010' => '缺少url参数',
        '41011' => '缺少agentid参数',
        '41016' => '缺少title参数',
        '41019' => '缺少 department 参数',
        '41017' => '缺少tagid参数',
        '41021' => '缺少suite_id参数',
        '41022' => '缺少suite_access_token参数',
        '41023' => '缺少suite_ticket参数',
        '41024' => '缺少secret参数',
        '41025' => '缺少permanent_code参数',
        '41033' => '缺少 description 参数',
        '41035' => '缺少外部联系人userid参数',
        '41036' => '不合法的企业对外简称',
        '41037' => '缺少「联系我」type参数',
        '41038' => '缺少「联系我」scene参数',
        '41039' => '无效的「联系我」type参数',
        '41040' => '无效的「联系我」scene参数',
        '41041' => '「联系我」使用人数超过限制',
        '41042' => '无效的「联系我」style参数',
        '41043' => '缺少「联系我」config_id参数',
        '41044' => '无效的「联系我」config_id参数',
        '41045' => 'API添加「联系我」达到数量上限',
        '41046' => '缺少企业群发消息id',
        '41047' => '无效的企业群发消息id',
        '41048' => '无可发送的客户',
        '41049' => '缺少欢迎语code参数',
        '41050' => '无效的欢迎语code',
        '41051' => '客户和服务人员已经开始聊天了',
        '42001' => 'access_token已过期',
        '42007' => 'pre_auth_code已过期',
        '42009' => 'suite_access_token已过期',
        '42013' => '小程序未登陆或登录态已经过期',
        '42014' => '任务卡片消息的task_id不合法',
        '42015' => '更新的消息的应用与发送消息的应用不匹配',
        '42016' => '更新的task_id不存在',
        '42017' => '按钮key值不存在',
        '42018' => '按钮key值不合法',
        '42019' => '缺少按钮key值不合法',
        '42020' => '缺少按钮名称',
        '43004' => '指定的userid未绑定微信或未关注微工作台（原企业号）',
        '44001' => '多媒体文件为空',
        '44004' => '文本消息content参数为空',
        '45001' => '多媒体文件大小超过限制',
        '45002' => '消息内容大小超过限制',
        '45004' => '应用description参数长度不符合系统限制',
        '45007' => '语音播放时间超过限制',
        '45008' => '图文消息的文章数量不符合系统限制',
        '45009' => '接口调用超过限制',
        '45022' => '应用name参数长度不符合系统限制',
        '45024' => '帐号数量超过上限',
        '45026' => '触发删除用户数的保护',
        '45032' => '图文消息author参数长度超过限制',
        '45033' => '接口并发调用超过限制',
        '46003' => '菜单未设置',
        '46004' => '指定的用户不存在',
        '48002' => 'API接口无权限调用',
        '48003' => '不合法的suite_id',
        '48004' => '授权关系无效',
        '48005' => 'API接口已废弃',
        '48006' => '接口权限被收回',
        '50001' => 'redirect_url未登记可信域名',
        '50002' => '成员不在权限范围',
        '50003' => '应用已禁用',
        '60001' => '部门长度不符合限制',
        '60003' => '部门ID不存在',
        '60004' => '父部门不存在',
        '60005' => '部门下存在成员',
        '60006' => '部门下存在子部门',
        '60007' => '不允许删除根部门',
        '60008' => '部门已存在',
        '60009' => '部门名称含有非法字符',
        '60010' => '部门存在循环关系',
        '60011' => '指定的成员/部门/标签参数无权限',
        '60012' => '不允许删除默认应用',
        '60020' => '访问ip不在白名单之中',
        '60028' => '不允许修改第三方应用的主页 URL',
        '60102' => 'UserID已存在',
        '60103' => '手机号码不合法',
        '60104' => '手机号码已存在',
        '60105' => '邮箱不合法',
        '60106' => '邮箱已存在',
        '60107' => '微信号不合法',
        '60110' => '用户所属部门数量超过限制',
        '60111' => 'UserID不存在',
        '60112' => '成员name参数不合法',
        '60123' => '无效的部门id',
        '60124' => '无效的父部门id',
        '60125' => '非法部门名字',
        '60127' => '缺少department参数',
        '60129' => '成员手机和邮箱都为空',
        '60132' => 'is_leader_in_dept和department的元素个数不一致',
        '72023' => '发票已被其他公众号锁定',
        '72024' => '发票状态错误',
        '72037' => '存在发票不属于该用户',
        '80001' => '可信域名不正确，或者无ICP备案',
        '81001' => '部门下的结点数超过限制（3W）',
        '81002' => '部门最多15层',
        '81003' => '标签下节点个数超过30000个',
        '81011' => '无权限操作标签',
        '81013' => 'UserID、部门ID、标签ID全部非法或无权限',
        '81014' => '标签添加成员，单次添加user或party过多',
        '82001' => '指定的成员/部门/标签全部无效',
        '82002' => '不合法的PartyID列表长度',
        '82003' => '不合法的TagID列表长度',
        '84014' => '成员票据过期',
        '84015' => '成员票据无效',
        '84019' => '缺少templateid参数',
        '84020' => 'templateid不存在',
        '84021' => '缺少register_code参数',
        '84022' => '无效的register_code参数',
        '84023' => '不允许调用设置通讯录同步完成接口',
        '84024' => '无注册信息',
        '84025' => '不符合的state参数',
        '84052' => '缺少caller参数',
        '84053' => '缺少callee参数',
        '84054' => '缺少auth_corpid参数',
        '84055' => '超过拨打公费电话频率',
        '84056' => '被拨打用户安装应用时未授权拨打公费电话权限',
        '84057' => '公费电话余额不足',
        '84058' => 'caller 呼叫号码不支持',
        '84059' => '号码非法',
        '84060' => 'callee 呼叫号码不支持',
        '84061' => '不存在外部联系人的关系',
        '84062' => '未开启公费电话应用',
        '84063' => 'caller不存在',
        '84064' => 'callee不存在',
        '84065' => 'caller跟callee电话号码一致',
        '84066' => '服务商拨打次数超过限制',
        '84067' => '管理员收到的服务商公费电话个数超过限制',
        '84069' => '拨打方被限制拨打公费电话',
        '84070' => '不支持的电话号码',
        '84071' => '不合法的外部联系人授权码',
        '84072' => '应用未配置客服',
        '84073' => '客服userid不在应用配置的客服列表中',
        '84074' => '没有外部联系人权限',
        '85002' => '包含不合法的词语',
        '85004' => '每企业每个月设置的可信域名不可超过20个',
        '85005' => '可信域名未通过所有权校验',
        '86001' => '参数 chatid 不合法',
        '86003' => '参数 chatid 不存在',
        '86004' => '参数 群名不合法',
        '86005' => '参数 群主不合法',
        '86006' => '群成员数过多或过少',
        '86007' => '不合法的群成员',
        '86008' => '非法操作非自己创建的群',
        '86101' => '仅群主才有操作权限',
        '86201' => '参数 需要chatid',
        '86202' => '参数 需要群名',
        '86203' => '参数 需要群主',
        '86204' => '参数 需要群成员',
        '86205' => '参数 字符串chatid过长',
        '86206' => '参数 数字chatid过大',
        '86207' => '群主不在群成员列表',
        '86215' => '会话ID已经存在',
        '86216' => '存在非法会话成员ID',
        '86217' => '会话发送者不在会话成员列表中',
        '86220' => '指定的会话参数不合法',
        '90001' => '未认证摇一摇周边',
        '90002' => '缺少摇一摇周边ticket参数',
        '90003' => '摇一摇周边ticket参数不合法',
        '90100' => '非法的对外属性类型',
        '90101' => '对外属性：文本类型长度不合法',
        '90102' => '对外属性：网页类型标题长度不合法',
        '90103' => '对外属性：网页url不合法',
        '90104' => '对外属性：小程序类型标题长度不合法',
        '90105' => '对外属性：小程序类型pagepath不合法',
        '90106' => '对外属性：请求参数不合法',
        '90200' => '缺少小程序appid参数',
        '90201' => '小程序通知的content_item个数超过限制',
        '90202' => '小程序通知中的key长度不合法',
        '90203' => '小程序通知中的value长度不合法',
        '90204' => '小程序通知中的page参数不合法',
        '90206' => '小程序未关联到企业中',
        '90207' => '不合法的小程序appid',
        '90208' => '小程序appid不匹配',
        '90300' => 'orderid 不合法',
        '90302' => '付费应用已过期',
        '90303' => '付费应用超过最大使用人数',
        '90304' => '订单中心服务异常，请稍后重试',
        '90305' => '参数错误，errmsg中有提示具体哪个参数有问题',
        '90306' => '商户设置不合法，详情请见errmsg',
        '90307' => '登录态过期',
        '90308' => '在开启IP鉴权的前提下，识别为无效的请求IP',
        '90309' => '订单已经存在，请勿重复下单',
        '90310' => '找不到订单',
        '90311' => '关单失败, 可能原因：该单并没被拉起支付页面; 已经关单；已经支付；渠道失败；单处于保护状态；等等',
        '90312' => '退款请求失败, 详情请看errmsg',
        '90313' => '退款调用频率限制，超过规定的阈值',
        '90314' => '订单状态错误，可能未支付，或者当前状态操作受限',
        '90315' => '退款请求失败，主键冲突，请核实退款refund_id是否已使用',
        '90316' => '退款原因编号不对',
        '90317' => '尚未注册成为供应商',
        '90318' => '参数nonce_str 为空或者重复，判定为重放攻击',
        '90319' => '时间戳为空或者与系统时间间隔太大',
        '90320' => '订单token无效',
        '90321' => '订单token已过有效时间',
        '90322' => '旧套件（包含多个应用的套件）不支持支付系统',
        '90323' => '单价超过限额',
        '90324' => '商品数量超过限额',
        '90325' => '预支单已经存在',
        '90326' => '预支单单号非法',
        '90327' => '该预支单已经结算下单',
        '90328' => '结算下单失败，详情请看errmsg',
        '90329' => '该订单号已经被预支单占用',
        '90338' => '已经过了可退款期限',
        '91040' => '获取ticket的类型无效',
        '93004' => '机器人被停用',
        '301002' => '无权限操作指定的应用',
        '301005' => '不允许删除创建者',
        '301012' => '参数 position 不合法',
        '301013' => '参数 telephone 不合法',
        '301014' => '参数 english_name 不合法',
        '301015' => '参数 mediaid 不合法',
        '301016' => '上传语音文件不符合系统要求',
        '301017' => '上传语音文件仅支持AMR格式',
        '301021' => '参数 userid 无效',
        '301022' => '获取打卡数据失败',
        '301023' => 'useridlist非法或超过限额',
        '301024' => '获取打卡记录时间间隔超限',
        '301036' => '不允许更新该用户的userid',
        '302003' => '批量导入任务的文件中userid有重复',
        '302004' => '组织架构不合法（1不是一棵树，2 多个一样的partyid，3 partyid空，4 partyid name 空，5 同一个父节点下有两个子节点 部门名字一样 可能是以上情况，请一一排查）',
        '302005' => '批量导入系统失败，请重新尝试导入',
        '302006' => '批量导入任务的文件中partyid有重复',
        '302007' => '批量导入任务的文件中，同一个部门下有两个子部门名字一样',
        '2000002' => 'CorpId参数无效',
        '600001' => '不合法的sn',
        '600002' => '设备已注册',
        '600003' => '不合法的硬件activecode',
        '600004' => '该硬件尚未授权任何企业',
        '600005' => '硬件Secret无效',
        '600007' => '缺少硬件sn',
        '600008' => '缺少nonce参数',
        '600009' => '缺少timestamp参数',
        '600010' => '缺少signature参数',
        '600011' => '签名校验失败',
        '600012' => '长连接已经注册过设备',
        '600013' => '缺少activecode参数',
        '600014' => '设备未网络注册',
        '600015' => '缺少secret参数',
        '600016' => '设备未激活',
        '600018' => '无效的起始结束时间',
        '600020' => '设备未登录',
        '600021' => '设备sn已存在',
        '600023' => '时间戳已失效',
        '600024' => '固件大小超过5M',
        '600025' => '固件名为空或者超过20字节',
        '600026' => '固件信息不存在',
        '600027' => '非法的固件参数',
        '600028' => '固件版本已存在',
        '600029' => '非法的固件版本',
        '600030' => '缺少固件版本参数',
        '600031' => '硬件固件不允许升级',
        '600032' => '无法解析硬件二维码',
        '600033' => '设备型号id冲突',
        '600034' => '指纹数据大小超过限制',
        '600035' => '人脸数据大小超过限制',
        '600036' => '设备sn冲突',
        '600037' => '缺失设备型号id',
        '600038' => '设备型号不存在',
        '600039' => '不支持的设备类型',
        '600040' => '打印任务id不存在',
        '600041' => '无效的offset或limit参数值',
        '600042' => '无效的设备型号id',
        '600043' => '门禁规则未设置',
        '600044' => '门禁规则不合法',
        '600045' => '设备已订阅企业信息',
        '610001' => '永久二维码超过每个员工5000的限制',
        '610003' => 'scene参数不合法',
        '610004' => 'userid不在客户联系配置的使用范围内',
        '610005' => '信息标示在企业微信不存在'
    );
}