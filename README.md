# today In History
 
历史上的今天

[示例网页](https://dituon.github.io/todayInHistory/)

### 结构

`data` 为根目录, 目前有 `anime` 和 `meme` 两个子类

子类下的日期按照`mm-dd`格式排序, 日期文件夹内储存当日事件数据

事件数据为 `json` 格式, 标准如下: 

(以 `data/meme/05-24/cherry.json` 为例)

```
{
    "id": "cherry",
    "res": ".png",
    "date": "2016-5-24",
    "title": "陈睿 —— b站未来有可能会倒闭，但绝不会变质。"
}
```

- `id`: 用于识别此事件, 同一日期下不能重复
- `res`: 资源文件(图片格式); 可简写为拓展名(`".png"`等价于`"cherry.png"`)
- `date`: 日期, `yyyy-mm-dd` 格式
- `title`: 事件描述，自由发挥

各级目录下由`index.json`索引

### 提交

对事件进行~~垃圾~~分类是非常麻烦的, 本项目由机器人完成自动分类

在子类下有`autoFile`目录, 可直接提交更改到此目录

机器人会在几秒钟内自动将事件移动到正确目录

**步骤**

> 方法1: (此方法适用于大量编辑)

1. 点击右上角 `Fork` 按钮, 将此项目fork到自己的账户中

2. 使用 [Git](https://git-scm.com/) 或 [GitHub Disktop](https://desktop.github.com/) 克隆此仓库
    - **Git**: `git clone https://github.com/Dituon/todayInHistory.git`
    - **GitHub Disktop**: `File` => `Clone reposit...` => `todayInHistory` => `Clone`

3. 在本地编辑后提交更改
    - **Git**: 
         ```
        git add .
        git commit -m "something"
        git push origin main
        ```
    - **GitHub Disktop**: `Commit to main` => `Push origin`

4. 提交[Pull requests](https://github.com/Dituon/todayInHistory/compare)

> 方法2: (少量文件)

1. 进入 [anime/autoFile](https://github.com/Dituon/todayInHistory/new/main/data/anime/autoFile) 或 [meme/autoFile](https://github.com/Dituon/todayInHistory/new/main/data/meme/autoFile) 目录

2. 点击右上角 `Add file` => `Create new file`, 参考 [结构](https://github.com/Dituon/todayInHistory#%E7%BB%93%E6%9E%84) 中的格式编写json文件并提交

3. 点击右上角 `Add file` => `Upload files`, 上传`res`中对应的图片文件并提交

> 更改合并到主仓库后, 可以在[示例网页](https://dituon.github.io/todayInHistory/)中看到添加的事件

### 规范

1. 对于具体年份未知的事件, 应当以作品发行年份作为事件年份
2. 对于设定发生在未来或古代的事件, 年份范围为`0001 - 9999`
3. 对于不存在的日期, 如`12月32日`, 应向下取最接近的日期