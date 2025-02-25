umask 002

export TERM=xterm

alias cs-validate='./vendor/bin/php-cs-fixer fix --dry-run --diff && ./vendor/bin/phpcs -p'
alias cs-fix='./vendor/bin/php-cs-fixer fix && ./vendor/bin/phpcbf'

alias php-cs-fixer='./vendor/bin/php-cs-fixer'
alias phpcs='./vendor/bin/phpcs'
alias phpcbf='./vendor/bin/phpcbf'

alias phpunit='./vendor/bin/phpunit'
