# Git workflow practice

## Initial repository

```bash
git init
git add .
git commit -m "Create MiniILIAS project structure"
git branch -M main
```

## Feature branch

```bash
git switch -c feature/course-enrollment
# edit files
git status
git diff
git add src/ database/ views/
git commit -m "Add course enrollment"
git switch main
git merge feature/course-enrollment
```

## Inspect history

```bash
git log --oneline --graph --decorate --all
git show <commit>
git blame src/Services/CourseService.php
```

## Conflict exercise

1. Change the same line in `README.md` on two branches.
2. Merge the first branch.
3. Merge the second branch.
4. Resolve the conflict markers.
5. Run tests and commit the resolution.

## ILIAS relevance

For an ILIAS repository you should understand:

- release branches versus development branches
- pull requests and code review
- reading `git diff`
- tracing a change with `git log` and `git blame`
- avoiding direct local changes to production core files
- testing changes in a staging environment
