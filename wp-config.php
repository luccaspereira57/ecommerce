<?php

/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do banco de dados
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */
// ** Configurações do banco de dados - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'ecommerce' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'root' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', '' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

define('FS_METHOD', 'direct');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         's_HZ]@I;<AZk:LV#UucZCHp(ox]Q}ZzRMx2O$:nJUTZ?PUmjd&i%!Sd>]UoI48@}' );
define( 'SECURE_AUTH_KEY',  'sg&aL9(EfI}kM8N4Y^3c5Ks[6#%XqjAavF`ErVyUxTpZ2f^c]`Ew#C`%y?a*7[d2' );
define( 'LOGGED_IN_KEY',    'VHsfMb#T5u(G8O0P3.9t.!~HdZ]xSFPb1x-}FpM >M:E5p8HSdjeR-:lp09+enG9' );
define( 'NONCE_KEY',        ':-mJtSlO$^jWE[:I%`T}w})#5}b(23DBMDT0n6T^MCrHZ}`:lHJ@RXzSu6Kt#]3S' );
define( 'AUTH_SALT',        ']zE^1gqKf<V$/S5Eo1C(jK~9{,K0%Y`UT{Q|s}%uzQLBd v [)naXA&.>*e!+ZH1' );
define( 'SECURE_AUTH_SALT', 'z;55BXp-~},bNil/a+LA#yK.14]CAE>gX)12xTchoo6$|9&Jw6!:QT]d(cM[V-cv' );
define( 'LOGGED_IN_SALT',   'S.1Z%^m)0=:>-UQLi=K:SpX;t!LCwK_^2E?ombP*cM21<~zV+U/ V3CP/UTAF%3y' );
define( 'NONCE_SALT',       'T#FwT.& 2YlsQS|Pb aQGz9Ye;j3<&fJT+hZm7FwRLb]`;6DN`o:uR_Yfc`Wb&1r' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Adicione valores personalizados entre esta linha até "Isto é tudo". */



/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';

