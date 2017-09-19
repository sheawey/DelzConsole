# 控制台组件

参考了Symfony的Console组件

## 输出样式

1. 普通输出

```php
    <?php
       use Delz\Console\Output\Stream; 
       
       //引入自动加载
       $loader = require __DIR__ . "/../vendor/autoload.php";
       
       $output = new Stream();
       $output->writeln("Hello world!");
       
```

2. 设置前景色、背景色和控制选项

前景色和前景色有：black、red、green、yellow、blue、magenta（紫红色）、cyan（青色）、white、default

控制选项有：bold、underscore、blink（闪）、reverse（反转）、conceal（隐藏）

```php
    <?php
        use Delz\Console\Output\Stream; 
               
        //引入自动加载
        $loader = require __DIR__ . "/../vendor/autoload.php";
               
        $output = new Stream();
        $output->writeln('<fg=black;bg=cyan>Hello world!</>');
        $output->writeln('<fg=black;bg=white;options=bold,underscore>Hello world!</>');
```

3. 内置样式

内置了四个info\error\question\comment样式
```php
    <?php
        use Delz\Console\Output\Stream; 
               
        //引入自动加载
        $loader = require __DIR__ . "/../vendor/autoload.php";
        
        $output = new Stream();
               
        $output->writeln("<info>Hello world!</info>");
        $output->writeln("<error>Hello world!</error>");
        $output->writeln("<question>Hello world!</question>");
        $output->writeln("<comment>Hello world!</comment>");
```


4. 自定义样式

```php
    <?php
        use Delz\Console\Output\Stream; 
        use Delz\Console\Output\Formatter\Style;
               
        //引入自动加载
        $loader = require __DIR__ . "/../vendor/autoload.php";
        
        $output = new Stream();
               
        $style = new Style();
        $style->setForeground("white");
        $style->setBackground("green");
        $style->setOptions(["bold","blink"]);
        $output->getFormatter()->setStyle('custom', $style);
        $output->writeln("<custom>Hello world!</custom>");
```

## 命令和命令容器

1. 添加命令

命令必须实现ICommand和集成抽象类Command

命令类必须实现execute方法，此方法有两个参数：

IInput $input 输入参数对象，获取参数可以调用方法 $input->getArguments()

IOutput $output 输入对象

下面是Command下的HelloCommand的执行


```php
    <?php
        use Delz\Console\Command\HelloCommand;
        
               
        //引入自动加载
        $loader = require __DIR__ . "/../vendor/autoload.php";
        
        $helloCommand = new HelloCommand();
        $helloCommand->run();
```

命令可以通过-v等参数获取版本,-h获取帮助信息

命令的写法可参考Command目录下HelloCommand和ListCommand的写法

2. 命令容器

可以把多条命令加到命令池Pool

```php
    //假设文件名console.php
    <?php
        use Delz\Console\Input\ArgvInput;
        use Delz\Console\Command\HelloCommand;
        use Delz\Console\Command\Pool;
        use Delz\Console\Command\ListCommand;
        
               
        //引入自动加载
        $loader = require __DIR__ . "/../vendor/autoload.php";
        
        $pool = new Pool();
        
        $helloCommand = new HelloCommand();
        $pool->add($helloCommand);
        
        $listCommand = new ListCommand();
        $pool->add($listCommand);
        
        //获取命令行参数
        $input = new ArgvInput();
        $args = $input->getArguments();
        
        //如果没有参数，说明没有任何命令可执行，显示所有命令
        if(count($args)===0) {
            $output->writeln("Command list:");
            foreach ($pool->all() as $k => $v) {
                $output->writeln("<comment>$k</comment>\t" . $v->getDescription());
            }
        } else {
            //第一个参数为命令名称
            $commandName = array_shift($args);
            if(!$pool->has($commandName)) {
                $output->writeln("<error>command " . $commandName . " not exist</error>");
            } else {
                $command = $pool->get($commandName);
                array_unshift($args,$commandName);
                $commandInput = new ArgvInput($args);
                $command->run($commandInput);
            }
        
        }
```

执行  php console.php 默认会出现命令列表

执行 php console.php hello 会执行HelloCommand，这里HelloCommand的name是hello

执行 php console.php hello -v 会显示HelloCommand命令的版本


