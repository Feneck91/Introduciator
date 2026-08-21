Introduciator - Changelog
=========================
This file lists the changes between versions of the Introduciator extension.

# Version 3.1.0
## Changes since 3.0.0
### New features
* [FEATURE] Added a **Topic mode**, alongside the existing Forum mode: instead of each member
  creating their own introduction topic in a dedicated forum, all members introduce themselves by
  posting in a single shared topic (their first post in it). The ACP lets admins pick either mode;
  boards upgrading keep Forum mode with no behaviour change until they switch.
  * Approval, the explanation page, the "already introduced" icon/link, and the ACP Statistics page
    all adapt to whichever mode is configured.
  * In Topic mode, "Approval with ability to edit" is not offered (it is a topic-visibility concept
    that doesn't apply to a single post inside a shared topic); only the very first post a member
    makes in the topic is ever subject to approval.
  * The ACP validates the chosen topic: it must exist, not be deleted, and not be a global
    announcement (which has no real containing forum).

# Version 3.0.0
## Changes since 2.0.0
### Bug fixes
* [BUG] Closed a race condition that let a user end up with more than one introduction topic
  (double-click, slow-network resubmit, back button + resubmit, two open tabs). Neither of phpBB's
  own duplicate-submission guards covered this case for a member's very first post. Fixed with an
  atomic per-user file claim; the extension now also refuses to enable, with a clear message, if its
  claim-storage directory isn't writable.
* [BUG] Fixed a fatal crash on the explanation page on PHP 8+: leftover `%forum_url%`-style
  placeholders in the default text were parsed as `vsprintf()` format specifiers.
* [BUG] Removed a redundant `acl_a_board` requirement from all 4 ACP modes; the extension's own
  `acl_a_introduciator_manage` permission already scopes this correctly.
* [BUG] Fixed an N+1 query pattern on the ACP Statistics page (one query per user instead of a
  single batched query) and added missing `sql_freeresult()` calls this surfaced.
* [BUG] Fixed a listener returning `$event` where phpBB's dispatcher never reads a listener's return
  value, only the mutated event object.
* [BUG] Fixed the introduce-approval-level template variables and the Statistics tab label, both
  broken by a naming mismatch between the code and the translations.
* [BUG] Replaced a 2020 deployed build that had never actually enforced anything (a brace-nesting
  bug put the whole "must introduce before posting" check inside the delete-only branch) with the
  already-fixed 2022 build, kept disabled until an admin points it at a real forum.

### Improvements
* [CODE] General phpBB coding-standards / validator compliance pass across the extension.
* [CODE] Moved the extension-listing URL out of the language files (it was duplicated, untranslated,
  byte-for-byte identical text in 8 of 9 locales) and computed it in the controller instead.
* [CODE] Added a next-steps notice pointing admins at the configuration page right after enabling
  the extension.
* [CODE] Tidied remaining old-style template placeholders to Twig syntax; removed an invalid `alt`
  attribute and a hard-coded colon in two event templates.
* Restored the "cancel and return to that forum" link on the explanation page.
* Extension version now consistent everywhere (composer.json, ACP module).

# Version 2.0.0 and earlier
Initial phpBB extension port of the [MOD Introduciator](https://www.phpbb.com/customise/db/mod/introduciator/),
with German, Simplified Chinese and Portuguese translations added along the way. See the commit
history for details.
