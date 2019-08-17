<?php
namespace Home\Model;
use Think\Model;
class UserConfigModel extends Model {
    protected $fields = array('cid', 'uid', 'config_name', 'config_key', 'config_value', 'time',
        '_type'=>array('cid'=>'int', 'uid'=>'int', 'config_name'=>'varchar', 'config_key'=>'varchar', 'config_value'=>'varchar', 'time'=>'int')
    );

    // 配置说明：
    //   uid=0时表示公共配置，uid>0时表示对应用户配置
    //   config_name 表示配置应用名称例如 Web、Weixin、Alipay等
    //   config_key 表示配置键名（最大32字节）
    //   config_value 表示配置值（最大32字节）

    // 获取配置信息
    public function getConfig($config_key, $config_name = null, $uid = 0) {
        $configData = array();
        $configData['uid'] = $uid;
        if ($config_name != null) {
            $configData['config_name'] = $config_name;
        }
        $configData['config_key'] = $config_key;
        $ret = $this->where($configData)->find();
        if ($ret) {
            return $ret['config_value'];
        } else if ($uid > 0) {
            return $this->getConfig($config_key, $config_name, 0);
        } else {
            return null;
        }
    }
}