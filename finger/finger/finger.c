#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#include "passwd.h"
#include "util.h"
#include "command.h"

int main(void)
{
    finger_command_t command = read_command();

    if (is_password_required(command.name)) {
        if (!check_password(command.password)) {
            puts("N/A");
            return 0;
        }
    }

    if (strlen(command.name) == 0) {
        char **name = get_all_users();
        printf("%-16s %-24s %-24s\n", "LOGIN", "FULL NAME", "OFFICE");
        while (*name) {
            passwd_entry_t passwd = find_passwd_line(*name);
            gecos_field_t gecos = parse_gecos_field(passwd.gecos);
            printf("%-16s %-24s %-24s\n", passwd.login, gecos.irl, gecos.office);
            ++name;
        }
        exit(0);
    }

    passwd_entry_t passwd = find_passwd_line(command.name);
    if (!passwd.login) {
        /* Not found */
        puts("N/A");
        return 0;
    }
    gecos_field_t gecos = parse_gecos_field(passwd.gecos);

    char *last = get_last_login(command.name);
    char *plan = get_user_plan(command.name);
    printf("Login name: %-27s In real life: %s\n"
           "Office: %-31s Home phone: %s\n"
           "Directory: %-28s Shell: %s\n"
           "%s\n"
           "Plan:\n"
           "%s\n",
           passwd.login, gecos.irl,
           gecos.office, gecos.phone_home,
           passwd.home, passwd.shell,
           last,
           plan);

    return 0;
}
