# Zero_ReviewsAiAssistant

The AI Assistant's tools for Zero Reviews: `list_reviews`, `moderate_reviews`. It also adds the `/reviews` command (`commands` argument of `Zero\AiAssistant\Model\Commands`, with `sort_order`).
A bridge module: Zero_AiAssistant (the chat, the tool pool) and Zero_Reviews
(the data) stay independent of each other. Install this one when a store uses
both.

- Registers the tools in the `tools` argument of `Zero\AiAssistant\Model\Tools`
  (di.xml, `\Proxy` items with `sortOrder`) and a `requires` entry per tool: a
  tool shows only while Zero_Reviews is enabled.
- Tool names, ACL resources (`Magento_Review::reviews_all`, `Magento_Review::pending`) and areas are the ones the
  tools had inside Zero_AiAssistant, so roles and stored proposals keep working. The
  area's ACL resource `Zero_AiAssistant::area_reviews` stays in AiAssistant.
- `module.xml` sequence: Zero_AiAssistant, Zero_Reviews, Magento_Review, so it loads after them.

Tests: `Test/Unit`.

## Install

Requires Magento Open Source 2.4.7–2.4.9 and PHP 8.2–8.4 with the GD extension built with WebP (`php -r 'var_dump(function_exists("imagewebp"));'` says `true`; Magento's own PHP requirements cover the rest). Without WebP in GD, Zero skips its WebP image copies and serves the originals.

```bash
composer require zerofront/module-zero-reviews-ai-assistant
bin/magento setup:upgrade
bin/magento setup:di:compile           # production mode
bin/magento setup:static-content:deploy # production mode
bin/magento cache:flush
```

Composer installs `zerofront/module-zero-ai-assistant`, `zerofront/module-zero-reviews` with it.

Part of [`zerofront/zero`](https://zerofront.dev), which installs the Zero theme and every Zero module at once.

What changed in each release: [CHANGELOG.md](CHANGELOG.md).

## License

OSL-3.0 or AFL-3.0, your choice: see `NOTICE.md`.

---

Zero is made by [Fixstacks](https://fixstacks.com).
Documentation: https://zerofront.dev/docs. Demo store: https://demo.zerofront.dev.
