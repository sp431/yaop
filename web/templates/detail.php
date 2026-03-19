<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>药品详情</title>
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

    /* 详情页面样式 */
    .detail-container {
      background-color: var(--card-background);
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .detail-header {
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 1px solid var(--border-color);
    }

    .detail-header h2 {
      color: var(--text-color);
      margin-bottom: 5px;
    }

    .detail-content {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 15px;
    }

    .detail-item {
      margin-bottom: 10px;
    }

    .detail-item label {
      display: block;
      font-weight: 500;
      margin-bottom: 5px;
      color: var(--text-color);
    }

    .detail-item p {
      padding: 8px 12px;
      background-color: #f8f9fa;
      border-radius: 4px;
      border: 1px solid var(--border-color);
      min-height: 40px;
    }

    .detail-actions {
      margin-top: 20px;
      display: flex;
      gap: 10px;
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
      <h1>药品详情</h1>
    </header>
    
    <div class="detail-container">
      <div class="detail-header">
        <h2><?php echo htmlspecialchars($medicine['通用名称']); ?></h2>
        <p><strong>商品名称：</strong><?php echo htmlspecialchars($medicine['商品名称']); ?></p>
      </div>
      
      <div class="detail-content">
        <div class="detail-item">
          <label>通用名称</label>
          <p><?php echo htmlspecialchars($medicine['通用名称']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>商品名称</label>
          <p><?php echo htmlspecialchars($medicine['商品名称']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>汉语拼音</label>
          <p><?php echo htmlspecialchars($medicine['汉语拼音']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>相关疾病</label>
          <p><?php echo htmlspecialchars($medicine['相关疾病']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>剂型</label>
          <p><?php echo htmlspecialchars($medicine['剂型']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>主要成份</label>
          <p><?php echo htmlspecialchars($medicine['主要成份']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>适应症</label>
          <p><?php echo htmlspecialchars($medicine['适应症']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>规格</label>
          <p><?php echo htmlspecialchars($medicine['规格']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>不良反应</label>
          <p><?php echo htmlspecialchars($medicine['不良反应']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>用法用量</label>
          <p><?php echo htmlspecialchars($medicine['用法用量']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>禁忌</label>
          <p><?php echo htmlspecialchars($medicine['禁忌']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>注意事项</label>
          <p><?php echo htmlspecialchars($medicine['注意事项']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>儿童用药</label>
          <p><?php echo htmlspecialchars($medicine['儿童用药']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>老人用药</label>
          <p><?php echo htmlspecialchars($medicine['老人用药']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>药物相互作用</label>
          <p><?php echo htmlspecialchars($medicine['药物相互作用']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>药理毒理</label>
          <p><?php echo htmlspecialchars($medicine['药理毒理']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>药代动力学</label>
          <p><?php echo htmlspecialchars($medicine['药代动力学']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>贮藏</label>
          <p><?php echo htmlspecialchars($medicine['贮藏']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>有效期</label>
          <p><?php echo htmlspecialchars($medicine['有效期']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>批准文号</label>
          <p><?php echo htmlspecialchars($medicine['批准文号']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>生产企业</label>
          <p><?php echo htmlspecialchars($medicine['生产企业']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>药品分类</label>
          <p><?php echo htmlspecialchars($medicine['药品分类']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>药品性质</label>
          <p><?php echo htmlspecialchars($medicine['药品性质']); ?></p>
        </div>
        
        <div class="detail-item">
          <label>备注</label>
          <p><?php echo htmlspecialchars($medicine['备注']); ?></p>
        </div>
      </div>
      
      <div class="detail-actions">
        <a href="index.php" class="btn btn-secondary">返回列表</a>
        <a href="index.php?action=edit&id=<?php echo $medicine['id']; ?>" class="btn btn-primary">修改</a>
      </div>
    </div>
  </div>
</body>
</html>