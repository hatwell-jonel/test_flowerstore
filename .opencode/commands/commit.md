---
description: Stage all changes and commit with a conventional commit message
---

Analyze the changes to determine the commit type based on the commit-changes skill. Run `git status` and `git diff --stat` to show what changed, then `git diff` to examine the actual diffs.

If the user provided a message ($ARGUMENTS) after `/commit`, validate it follows conventional commit format (type(scope): summary) and use it directly.

If no message was provided, analyze the changes and propose a conventional commit message, then ask the user to confirm.

Stage all modified and untracked files (`git add -A`), then commit.

Never force-push, amend, or use interactive mode unless explicitly asked.
