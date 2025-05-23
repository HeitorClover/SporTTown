<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/style_estudante.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-image: url('imagens/home.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        color: #333;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
        padding: 40px 20px;
        }
        .form-wrapper {
        width: 100%;
        max-width: 700px;
        margin-bottom: 40px;
        min-height: 100vh;
    }

        .form-box {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-header h1 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 28px;
            color: #2c3e50;
            font-weight: 600;
        }

        h3 {
            margin-bottom: 15px;
            font-size: 18px;
            color: #34495e;
            border-left: 4px solid #27ae60;
            padding-left: 10px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            pointer-events: none;
        }

        .input-group input {
            width: 100%;
            padding: 12px 40px 12px 40px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        .input-group input:focus {
            border-color: #27ae60;
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }

        input[type="submit"] {
            width: 100%;
            background-color: #2ecc71;
            color: white;
            padding: 14px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #27ae60;
        }

        p {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            color: green;
            margin-bottom: 20px;
            background-color: #2F4F4F;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #c3e6cb;
        }

        button {
            background-color: #7f8c8d;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 15px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #607d8b;
        }

        /* Estilos para os responsáveis */
        .responsavel-group {
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #f9f9f9;
            position: relative;
            transition: all 0.3s ease;
        }

        .responsavel-group:hover {
            border-color: #bdbdbd;
        }

        .responsavel-group input {
            margin-bottom: 10px;
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .remove-responsavel {
            position: absolute;
            right: 10px;
            top: 10px;
            padding: 5px 8px;
            font-size: 12px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #add-responsavel {
            margin: 10px 0 20px;
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #add-responsavel:hover {
            background-color: #2980b9;
        }

        #add-responsavel i {
            margin-right: 5px;
        }
    </style>
</head>

<body>
  <?php if(isset($_GET['sucesso'])): ?>
        <p style="color: green;">Estudante cadastrado com sucesso!</p>
    <?php endif; ?>
<div class="form-wrapper">
    <div class="container" id="aluno">
        <div class="form-box">
            <div class="form-header">
                <h1>Cadastro Aluno</h1>
            </div>
            <form action="router.php?rota=cadastrar" method="POST" id="formCadastro">
                <h3>Dados do Estudante</h3>
                <div class="input-group">
                    <i class="fas fa-id-card"></i>
                    <input type="text" name="matricula" placeholder="Matrícula" maxlength="7" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="nome" placeholder="Nome" maxlength="100" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-graduation-cap"></i>
                    <input type="text" name="curso" placeholder="Curso" maxlength="50" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="number" name="ano_ingresso" placeholder="Ano de Ingresso" min="2000" max="2100" required>
                </div>

                <h3>Dados do(s) Responsável(is)</h3>
                <div id="responsaveis-container">
                    <!-- Primeiro bloco de responsável -->
                    <div class="responsavel-group">
                        <div class="input-group">
                            <i class="fas fa-user-tie"></i>
                            <input type="text" name="responsaveis[0][nome]" placeholder="Nome do Responsável" maxlength="100" required>
                        </div>
                        <div class="input-group">
                            <i class="fas fa-phone"></i>
                            <input type="text" name="responsaveis[0][contato]" placeholder="(00) 00000-0000" class="telefone form-control" maxlength="15" class="form-control" required>
                            
                        </div>
                        <div class="input-group">
                            <i class="fas fa-users"></i>
                            <input type="text" name="responsaveis[0][parentesco]" placeholder="Parentesco" maxlength="19">
                        </div>
                    </div>
                </div>

                <button type="button" id="add-responsavel">
                    <i class="fas fa-plus-circle"></i> Adicionar Responsável
                </button>
                
                <input type="submit" value="Cadastrar">
            </form>
        </div>
    </div>
</div>

<button onclick="window.location.href='index.php'">
    <i class="fas fa-arrow-left"></i> Voltar ao Menu
</button>

<script>
$(document).ready(function() {
    let responsavelCount = 1;
    
    $('#add-responsavel').click(function() {
        if(responsavelCount >= 5) {
            alert('Máximo de 5 responsáveis permitidos!');
            return;
        }

        const newGroup = `
            <div class="responsavel-group">
                <div class="input-group">
                    <i class="fas fa-user-tie"></i>
                    <input type="text" name="responsaveis[${responsavelCount}][nome]" placeholder="Nome do Responsável" maxlength="100" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-phone"></i>
                    <input type="text" name="responsaveis[${responsavelCount}][contato]" class="telefone" placeholder="(00) 00000-0000" maxlength="19" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-users"></i>
                    <input type="text" name="responsaveis[${responsavelCount}][parentesco]" placeholder="Parentesco" maxlength="19" >
                </div>
                <button type="button" class="remove-responsavel">
                    <i class="fas fa-times"></i> Remover
                </button>
            </div>
        `;
        
        $('#responsaveis-container').append(newGroup);
        responsavelCount++;
    });

    $(document).on('click', '.remove-responsavel', function() {
        if($('.responsavel-group').length > 1) {
            $(this).parent().remove();
            // Reindexa os grupos
            $('.responsavel-group').each(function(index) {
                $(this).find('input').each(function() {
                    const name = $(this).attr('name').replace(/responsaveis\[\d+\]/, `responsaveis[${index}]`);
                    $(this).attr('name', name);
                });
            });
            responsavelCount = $('.responsavel-group').length;
        } else {
            alert('É necessário ter pelo menos um responsável!');
        }
    });
});

// Função que aplica a máscara de telefone
        function aplicarMascaraTelefone(input) {
            input.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.slice(0, 11);

                if (value.length <= 10) {
                    value = value.replace(/^(\d{0,2})(\d{0,4})(\d{0,4})/, (_, a, b, c) => {
                        return `(${a}${b ? `) ${b}` : ''}${c ? `-${c}` : ''}`;
                    });
                } else {
                    value = value.replace(/^(\d{0,2})(\d{0,5})(\d{0,4})/, (_, a, b, c) => {
                        return `(${a}${b ? `) ${b}` : ''}${c ? `-${c}` : ''}`;
                    });
                }

                e.target.value = value;
            });
        }

        // Aplica a máscara em todos os inputs .telefone já existentes ao carregar
        document.querySelectorAll('.telefone').forEach(aplicarMascaraTelefone);

</script>

</body>
</html>