<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SABIÁ — EEEP José de Barcelos</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    /* limita a largura do conteúdo nessa página */
    .container {
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 16px;
    }

    /* Estrutura de Grid: Conteúdo principal + Lateral */
    .main-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 24px;
      margin-top: 24px;
      margin-bottom: 80px; /* espaço para o bottom-nav no mobile */
    }

    /* Cards gerais do sistema */
    .card {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      padding: 20px;
      margin-bottom: 20px;
      border: 1px solid #eef2f5;
    }

    .card-title {
      font-size: 18px;
      font-weight: bold;
      color: #158a2f;
      margin-bottom: 14px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* Seção de atalhos rápidos do sistema */
    .grid-atalhos {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 12px;
      margin-top: 10px;
    }

    .btn-atalho {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 16px;
      background: #f8f9fa;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      text-decoration: none;
      color: #333;
      font-weight: 600;
      font-size: 14px;
      transition: all 0.2s ease;
      text-align: center;
    }

    .btn-atalho:hover {
      background: #f0faf4;
      border-color: #158a2f;
      transform: translateY(-2px);
    }

    .icon-atalho {
      font-size: 24px;
      margin-bottom: 8px;
    }

    /* caixa verde com as regras disciplinares da escola */
    .rule-box {
      background: #f0faf4;
      border-left: 4px solid #158a2f;
      padding: 16px;
      border-radius: 6px;
      font-size: 13px;
      line-height: 1.6;
      color: #333;
    }

    .rule-box strong {
      color: #158a2f;
    }

    /* Destaque para regras críticas (Notificações/Suspensão) */
    .alerta-box {
      background: #fff5f5;
      border-left: 4px solid #e53e3e;
      padding: 12px;
      border-radius: 6px;
      font-size: 13px;
      color: #c53030;
      margin-top: 10px;
    }

    /* ajuste mobile: sidebar vai pra baixo do conteúdo principal */
    @media (max-width: 900px) {
      .main-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>

  <header class="topbar">
    <div class="brand">
      <div class="logo"><span style="color:#f1ab08;">SABIÁ</span></div>
      <div class="subtitle">Gestão de Atrasos e Ocorrências — 2026</div>
    </div>
    <div class="angled-deco"></div>
  </header>

  <nav class="nav-row">
    <div class="container nav-inner">
      <div class="nav-header-row"></div>
      <div class="nav-links" id="navLinks">
        <a href="index.php" class="active"> INÍCIO</a>
        <a href="registro.php"> REGISTRO</a>
        <a href="cadastro.php"> CADASTRAR</a>
        <a href="historico.php"> HISTÓRICO</a>
      </div>
    </div>
  </nav>

  <div class="toast" id="toast"></div>

  <main class="container">
    <div class="main-grid">
      
      <div class="content-main">
        
        <div class="card">
          <div class="card-title">🦅 Sistema SABIÁ</div>
          <p style="font-size: 14.5px; color: #4a5568; line-height: 1.6; margin-bottom: 0;">
            Bem-vindo ao painel de gestão escolar da <strong>EEEP José de Barcelos</strong>. 
            O SABIÁ foi desenvolvido para centralizar e simplificar o dia a dia da coordenação, permitindo o controle rápido de pontualidade, uniformes e saídas da comunidade discente.
          </p>
        </div>


        <div class="card">
          <div class="card-title">⚙️ Recursos Disponíveis</div>
          <ul style="margin-left: 18px; font-size: 14px; color: #4a5568; line-height: 1.8;">
            <li><strong>Cadastro de Alunos:</strong> Insira novos estudantes no banco de dados para habilitar o rastreamento disciplinar.</li>
            <li><strong>Controle de Fluxo:</strong> Registre de forma prática se o aluno chegou atrasado, se está com o fardamento incorreto ou se precisou sair mais cedo da instituição.</li>
            <li><strong>Gestão de Penalidades:</strong> Histórico automatizado focado no acúmulo de advertências, ocorrências e notificações geradas.</li>
          </ul>
        </div>

      </div>

      <aside class="sidebar">
        <div class="card">
          <div class="card-title">⚖️ Diretrizes e Níveis</div>
          <div class="rule-box">
            <p>O sistema processa os horários de entrada da manhã de acordo com os critérios:</p>
            <ul style="margin-left: 18px; margin-top: 8px; margin-bottom: 12px;">
              <li><strong>Até 07:20:</strong> Entrada Normal</li>
              <li><strong>07:21 às 07:30:</strong> Tolerância</li>
              <li><strong>A partir de 07:31:</strong> Ocorrência Direta</li>
            </ul>
            
            <hr style="border:0; border-top:1px solid #d2e7d7; margin:12px 0;" />
            
            <p style="margin-bottom: 6px;"><strong>Regra de Conversão Acumulada:</strong></p>
            <p>A cada <strong>3 Advertências</strong> → Gera-se automaticamente <strong>1 Ocorrência</strong>.</p>
            <p style="margin-top: 4px;">A cada <strong>3 Ocorrências</strong> → Gera-se automaticamente <strong>1 Notificação</strong> para contato com o responsável.</p>
            
            <div class="alerta-box">
              ⚠️ <strong>Atenção:</strong> O acúmulo de <strong>3 Notificações</strong> gera automaticamente o status de <strong>Suspensão</strong>.
            </div>
            
            <hr style="border:0; border-top:1px solid #d2e7d7; margin:12px 0;" />
            
            <p><strong>Fardamento Inadequado:</strong> Marcar esta opção gera uma Ocorrência Direta imediata, independente do horário de chegada.</p>
          </div>
        </div>
      </aside>

    </div></main>

  <nav class="bottom-nav">
    <a href="index.php" class="active">
      <span class="nav-icon">🏠</span>
      <span class="nav-text">Início</span>
    </a>
    <a href="registro.php">
      <span class="nav-icon">📝</span>
      <span class="nav-text">Registro</span>
    </a>
    <a href="cadastro.php">
      <span class="nav-icon">➕</span>
      <span class="nav-text">Cadastrar</span>
    </a>
    <a href="historico.php">
      <span class="nav-icon">⏳</span>
      <span class="nav-text">Histórico</span>
    </a>
  </nav>

  <script>
    // Abre/fecha o menu hambúrguer no mobile
    function toggleMenu() {
      document.getElementById('navLinks').classList.toggle('active');
    }
  </script>

</body>

</html>
