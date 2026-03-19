<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>添加药品</title>
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
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: 500;
    }

    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 8px 12px;
      border: 1px solid var(--border-color);
      border-radius: 4px;
      font-size: 14px;
    }

    .form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .form-actions {
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
      <h1>添加药品</h1>
    </header>
    
    <div class="form-container">
      <form action="index.php?action=add" method="POST">
        <div class="form-group">
          <label for="通用名称">通用名称</label>
          <input type="text" id="通用名称" name="通用名称" required>
        </div>
        
        <div class="form-group">
          <label for="商品名称">商品名称</label>
          <input type="text" id="商品名称" name="商品名称">
        </div>
        
        <div class="form-group">
          <label for="汉语拼音">汉语拼音</label>
          <input type="text" id="汉语拼音" name="汉语拼音">
        </div>
        
        <div class="form-group">
          <label for="相关疾病">相关疾病</label>
          <input type="text" id="相关疾病" name="相关疾病">
        </div>
        
        <div class="form-group">
          <label for="剂型">剂型</label>
          <input type="text" id="剂型" name="剂型">
        </div>
        
        <div class="form-group">
          <label for="主要成份">主要成份</label>
          <textarea id="主要成份" name="主要成份"></textarea>
        </div>
        
        <div class="form-group">
          <label for="适应症">适应症</label>
          <textarea id="适应症" name="适应症"></textarea>
        </div>
        
        <div class="form-group">
          <label for="规格">规格</label>
          <input type="text" id="规格" name="规格">
        </div>
        
        <div class="form-group">
          <label for="不良反应">不良反应</label>
          <textarea id="不良反应" name="不良反应"></textarea>
        </div>
        
        <div class="form-group">
          <label for="用法用量">用法用量</label>
          <textarea id="用法用量" name="用法用量"></textarea>
        </div>
        
        <div class="form-group">
          <label for="禁忌">禁忌</label>
          <textarea id="禁忌" name="禁忌"></textarea>
        </div>
        
        <div class="form-group">
          <label for="注意事项">注意事项</label>
          <textarea id="注意事项" name="注意事项"></textarea>
        </div>
        
        <div class="form-group">
          <label for="儿童用药">儿童用药</label>
          <textarea id="儿童用药" name="儿童用药"></textarea>
        </div>
        
        <div class="form-group">
          <label for="老人用药">老人用药</label>
          <textarea id="老人用药" name="老人用药"></textarea>
        </div>
        
        <div class="form-group">
          <label for="药物相互作用">药物相互作用</label>
          <textarea id="药物相互作用" name="药物相互作用"></textarea>
        </div>
        
        <div class="form-group">
          <label for="药理毒理">药理毒理</label>
          <textarea id="药理毒理" name="药理毒理"></textarea>
        </div>
        
        <div class="form-group">
          <label for="药代动力学">药代动力学</label>
          <textarea id="药代动力学" name="药代动力学"></textarea>
        </div>
        
        <div class="form-group">
          <label for="贮藏">贮藏</label>
          <input type="text" id="贮藏" name="贮藏">
        </div>
        
        <div class="form-group">
          <label for="有效期">有效期</label>
          <input type="text" id="有效期" name="有效期">
        </div>
        
        <div class="form-group">
          <label for="批准文号">批准文号</label>
          <input type="text" id="批准文号" name="批准文号">
        </div>
        
        <div class="form-group">
          <label for="生产企业">生产企业</label>
          <input type="text" id="生产企业" name="生产企业">
        </div>
        
        <div class="form-group">
          <label for="药品分类">药品分类</label>
          <input type="text" id="药品分类" name="药品分类">
        </div>
        
        <div class="form-group">
          <label for="药品性质">药品性质</label>
          <input type="text" id="药品性质" name="药品性质">
        </div>
        
        <div class="form-group">
          <label for="备注">备注</label>
          <textarea id="备注" name="备注"></textarea>
        </div>
        
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">保存</button>
          <a href="index.php" class="btn btn-secondary">取消</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>