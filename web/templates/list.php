<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>药品说明书管理</title>
  <style>
    /* 全局样式 */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Arial', sans-serif;
      line-height: 1.6;
      color: #333;
      background-color: #f8f9fa;
    }

    /* 马卡龙绿主题色 */
    :root {
      --macaron-green: #a8d5ba;
      --macaron-green-dark: #7fb08f;
      --macaron-green-light: #c9e5d3;
      --text-color: #333;
      --background-color: #f8f9fa;
      --card-background: #ffffff;
      --border-color: #e0e0e0;
    }

    /* 容器 */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    /* 头部 */
    header {
      background-color: var(--macaron-green);
      color: white;
      padding: 20px;
      text-align: center;
      margin-bottom: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    header h1 {
      font-size: 2rem;
      font-weight: 600;
    }

    /* 按钮样式 */
    .btn {
      display: inline-block;
      padding: 8px 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
      font-weight: 500;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .btn-primary {
      background-color: var(--macaron-green);
      color: white;
    }

    .btn-primary:hover {
      background-color: var(--macaron-green-dark);
    }

    .btn-secondary {
      background-color: #6c757d;
      color: white;
      margin-left: 5px;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
    }

    .btn-danger {
      background-color: #dc3545;
      color: white;
      margin-left: 5px;
    }

    .btn-danger:hover {
      background-color: #c82333;
    }

    /* 表格样式 */
    table {
      width: 100%;
      border-collapse: collapse;
      background-color: var(--card-background);
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid var(--border-color);
    }

    th {
      background-color: var(--macaron-green-light);
      font-weight: 600;
      color: var(--text-color);
    }

    tr:hover {
      background-color: #f8f9fa;
    }

    /* 搜索框 */
    .search-container {
      margin-bottom: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .search-box {
      display: flex;
      gap: 10px;
    }

    .search-box input {
      padding: 8px 12px;
      border: 1px solid var(--border-color);
      border-radius: 4px;
      font-size: 14px;
      width: 300px;
    }

    /* 操作按钮组 */
    .action-buttons {
      display: flex;
      gap: 5px;
    }

    /* 消息提示 */
    .message {
      background-color: var(--macaron-green-light);
      padding: 10px;
      border-radius: 4px;
      margin-bottom: 20px;
    }

    /* 响应式设计 */
    @media (max-width: 768px) {
      .container {
        padding: 10px;
      }
      
      table {
        font-size: 14px;
      }
      
      th, td {
        padding: 8px 10px;
      }
      
      .search-box input {
        width: 200px;
      }
      
      .action-buttons {
        flex-direction: column;
      }
      
      .btn {
        font-size: 12px;
        padding: 6px 12px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <h1>药品说明书管理</h1>
    </header>
    
    <?php if (!empty($message)): ?>
    <div class="message">
      <?php echo $message; ?>
    </div>
    <?php endif; ?>
    
    <div class="search-container">
      <div class="search-box">
        <form action="index.php" method="GET">
          <input type="text" name="search" placeholder="搜索药品..." value="<?php echo htmlspecialchars($search); ?>">
          <button type="submit" class="btn btn-primary">搜索</button>
        </form>
      </div>
      <div style="display: flex; gap: 10px;">
        <a href="index.php?action=import" class="btn btn-primary">导入</a>
        <a href="index.php?action=export" class="btn btn-primary">导出</a>
        <a href="index.php?action=add" class="btn btn-primary">添加药品</a>
      </div>
    </div>
    
    <table>
      <thead>
        <tr>
          <th>序号</th>
          <th>通用名称</th>
          <th>商品名称</th>
          <th>相关疾病</th>
          <th>用法用量</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($medicines)): ?>
          <?php foreach ($medicines as $index => $medicine): ?>
            <tr>
              <td><?php echo $index + 1; ?></td>
              <td><?php echo htmlspecialchars($medicine['通用名称']); ?></td>
              <td><?php echo htmlspecialchars($medicine['商品名称']); ?></td>
              <td><?php echo htmlspecialchars($medicine['相关疾病']); ?></td>
              <td><?php echo htmlspecialchars($medicine['用法用量']); ?></td>
              <td>
                <div class="action-buttons">
                  <a href="index.php?action=detail&id=<?php echo $medicine['id']; ?>" class="btn btn-primary">详情</a>
                  <a href="index.php?action=edit&id=<?php echo $medicine['id']; ?>" class="btn btn-secondary">修改</a>
                  <a href="index.php?action=delete&id=<?php echo $medicine['id']; ?>" class="btn btn-danger" onclick="return confirm('确定要删除这个药品吗？');">删除</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" style="text-align: center; padding: 20px;">暂无药品数据</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>