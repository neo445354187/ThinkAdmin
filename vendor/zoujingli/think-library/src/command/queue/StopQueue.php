<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace think\admin\command\queue;

use think\admin\command\Queue;
use think\console\Input;
use think\console\Output;

/**
 * 平滑停止任务的所有进程
 * Class StopQueue
 * @package think\admin\command\queue
 */
class StopQueue extends Queue
{

    /**
     * 指令属性配置
     */
    protected function configure()
    {
        $this->setName('xtask:stop')->setDescription('Smooth stop of all task processes');
    }

    /**
     * 停止所有任务执行
     * @param Input $input
     * @param Output $output
     */
    protected function execute(Input $input, Output $output)
    {
        $keyword = $this->process->think('xtask:');
        if (count($result = $this->process->query($keyword)) < 1) {
            $output->warning("There is no task process to finish");
        } else foreach ($result as $item) {
            $this->process->close($item['pid']);
            $output->info("Sending end process {$item['pid']} signal succeeded");
        }
    }
}
