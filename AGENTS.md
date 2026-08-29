# 项目组织约定

## 目录与职责

- `workflow/src/` 只存放核心业务逻辑，不得包含 Alfred Script Filter 的数据结构、JSON 字段或控制台输出逻辑。
- 每个核心类使用 `Alfred\Workflow` 命名空间，并遵循 PSR-4：类名必须与文件名一致。
- `workflow/AlfredAdapter.php` 是 Alfred 的适配与运行入口。所有 Alfred 相关逻辑均放在此文件，包括 Script Filter 数据组装、JSON 编码和向标准输出写入结果。
- 核心类只返回与运行环境无关的普通 PHP 值，由 `AlfredAdapter.php` 将其转换为 Alfred 所需格式。

## 加载与运行

- Composer 在 `workflow/composer.json` 中将 `Alfred\Workflow\` 映射至 `workflow/src/`。
- 运行入口通过 `workflow/vendor/autoload.php` 加载核心类，不直接 `require` 单个核心源文件。
- 新增或重命名核心类后，运行 `composer dump-autoload --working-dir=workflow` 更新自动加载文件。
- 使用 `php workflow/AlfredAdapter.php` 运行示例。

## Alfred Script Filter 输出

- 标准输出必须是有效的 Alfred Script Filter JSON，不得混入日志或调试文本。
- 每个结果放在顶层 `items` 数组中；标题使用 `title` 字段。
- JSON 编码使用 `JSON_THROW_ON_ERROR`，避免静默忽略编码错误。
- 当前 Hello 示例的输出为 `{"items":[{"title":"Hello Alfred"}]}`。

## 验证

修改后至少执行：

```bash
php workflow/AlfredAdapter.php
cd workflow && vendor/bin/phpstan analyse src AlfredAdapter.php --no-progress
cd workflow && vendor/bin/php-cs-fixer fix --dry-run --diff --using-cache=no
```
