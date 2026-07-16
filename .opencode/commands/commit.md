---
description: Stage all changes and commit with a conventional commit message
---

Run `git status` first, then `git diff --stat` to show what changed.
Stage all modified and untracked files (`git add -A`).
Then commit with the message: $ARGUMENTS.
If no message is provided, ask the user for a concise commit message matching the repo style.