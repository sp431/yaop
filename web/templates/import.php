<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>导入药品</title>
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

    /* 表单样式 */
    .form-container {
      background-color: var(--card-background);
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      max-width: 600px;
      margin: 0 auto;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: 500;
    }

    .form-group input[type="file"] {
      width: 100%;
      padding: 8px;
      border: 1px solid var(--border-color);
      border-radius: 4px;
    }

    .form-actions {
      margin-top: 20px;
      display: flex;
      gap: 10px;
    }

    .info-box {
      background-color: var(--macaron-green-light);
      padding: 10px;
      border-radius: 4px;
      margin-bottom: 15px;
    }

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
      <h1>导入药品</h1>
    </header>
    
    <?php if (isset($_GET['message'])): ?>
    <div class="message">
      <?php echo htmlspecialchars($_GET['message']); ?>
    </div>
    <?php endif; ?>
    
    <div class="form-container">
      <div class="info-box">
        <p><strong>导入说明：</strong></p>
        <ul>
          <li>请确保CSV文件包含以下字段：通用名称、商品名称、汉语拼音、相关疾病、剂型、主要成份、适应症、规格、不良反应、用法用量、禁忌、注意事项、儿童用药、老人用药、药物相互作用、药理毒理、药代动力学、贮藏、有效期、批准文号、生产企业、药品分类、药品性质、备注</li>
          <li>字段顺序应与上述顺序一致</li>
          <li>文件编码应为UTF-8</li>
        </ul>
      </div>
      
      <form action="index.php?action=import" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="csvFile">选择CSV文件</label>
          <input type="file" id="csvFile" name="csvFile" accept=".csv" required>
        </div>
        
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">导入</button>
          <a href="index.php" class="btn btn-secondary">取消</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>