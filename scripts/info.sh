pr-title=$(cat info/pr-title)
pr-title=${pr-title:-dev}

echo "pr-title=${pr-title}" >> $GITHUB_ENV
echo "version_commit=$(cat info/version_commit)" >> $GITHUB_ENV