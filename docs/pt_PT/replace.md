# Remplacer

**Ferramentas → Substituir**

Esta ferramenta permite substituir rapidamente equipamentos e comandos, por exemplo no caso de mudança de plugin, ou de um módulo.

Assim como as opções de substituição na configuração avançada de um comando, ele substitui os comandos nos cenários e outros, mas também permite transferir as propriedades do equipamento e os comandos.

## Filtres

Você pode exibir apenas determinados equipamentos para maior legibilidade, filtrando por objeto ou por plugin.

> No caso de substituição de equipamento por equipamento de outro plugin, selecione os dois plugins.

## Options

> **Observação**
>
> Se nenhuma dessas opções estiver marcada, a substituição equivale ao uso da função _Substitua este comando pelo comando_ em configuração avançada.

- **Copiar configuração do dispositivo de origem** :
  Para cada equipamento, será copiado da fonte para o destino (lista não exaustiva) :
  _ O objeto pai,
  _ As categorias,
  * Propriedades *de ativos* e *visível*,
  * Comentários e etiquetas,
  _ Encomenda (Painel),
  _ A largura e a altura (painel de ladrilhos),
  _ Configurações de curva de ladrilho,
  _ Parâmetros opcionais,
  _ A configuração de exibição da tabela,
  _ o tipo genérico,
  * A propriedade *tempo esgotado\*
  * A configuração *atualização automática*,
  * Alertas de bateria e comunicação,

O equipamento de origem também será substituído pelo equipamento de destino no **Projeto** e a **Visualizações**.

_Este equipamento também será substituído pelo equipamento alvo em Desenhos e Vistas._

- **Ocultar equipamento de origem** : Permite tornar o equipamento de origem invisível uma vez substituído pelo equipamento de destino.

- **Copiar configuração do comando de origem** :
  Para cada pedido, será copiado da origem para o destino (lista não exaustiva) :
  * A propriedade *visível*,
  * Encomenda (Painel),
  _ L'historisation,
  _ Os widgets Dashboard e Mobile usados,
  _ O tipo genérico,
  _ Parâmetros opcionais,
  * As configurações *jeedomPreExecCmd* e *jeedomPostExecCmd* (ação),
  * Configurações de ação de valor (informações),
  _ ícone,
  _ A ativação e o diretório em _Linha do tempo_,
  * As configurações de *Cálculo* e *redondo*,
  * A configuração do influxDB,
  _ A configuração do valor de repetição,
  _ Alertas,

- **Excluir histórico de comandos de destino** : Exclui os dados do histórico de comandos de destino.

- **Copiar histórico de comandos de origem** : Copie o histórico do comando de origem para o comando de destino.

## Remplacements

O botão **Filtro** No canto superior direito permite visualizar todos os equipamentos, seguindo os filtros por objeto e por plugin.

Para cada equipamento :

- Marque a caixa no início da linha para ativar sua substituição.
- Selecione à direita o equipamento pelo qual será substituído.
- Clique em seu nome para ver seus comandos e indique quais comandos os substituem. Ao escolher um equipamento, a ferramenta preenche essas opções se encontrar um pedido do mesmo tipo e mesmo nome no equipamento de destino.

> **Observação**
>
> Quando você indica um dispositivo de destino em um dispositivo de origem, esse dispositivo de destino é desabilitado na lista.
