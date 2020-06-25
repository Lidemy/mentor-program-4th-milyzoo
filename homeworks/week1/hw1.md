## 交作業流程

### 先設定好 GitHub 專案
1. 透過 GitHub classroom 的連結來複製一份課綱到自己的 GitHub 底下
2. 把剛剛複製的那份課綱 clone 到自己的電腦上
3. 輸入 `git branch <branch 名稱>` 來新建一個 Branch
4. 接著用 `git checkout <branch 名稱>` 切換到剛剛建立的 Branch
> 接下來 **branch 名稱** 都用 **week1** 來說明。  

### 寫作業
1. 打開本機中 hw.md 檔案寫作業 ，完成後存檔。
2. 檢查作業是否完成需求，及看過當週的自我檢討並修正。  

### 交作業
1. 上述作業存檔完先 commit（指令：`git commit -am "commit message"`）
2. 把本機檔案 push 到 GitHub 上面（指令：git push origin week1）
3. 到 GitHbub 點擊 Pull requests，把剛剛的 branch week1 merge 到原本的 master
4. 把 Pull requests 的連結複製，貼到學習系統上交作業的 PR 連結格子裡，再按送出鍵
5. 如果作業沒有問題的話，助教批改完會按 Merge pull request，並刪掉原本的 branch
6. 回到本機，`git checkout master` 切回 master，再 `git pull origin master` 讓自己本機的 master 與 遠端的 master 同步
7. 最後把本機的 week1 branch 刪掉（指令：`git branch -d week1`）
8. 完成