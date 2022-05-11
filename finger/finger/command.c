#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#include "command.h"
#include "util.h"

finger_command_t read_command() {
    char command[MAX_COMMAND];
    fgets(command, sizeof(command) * MAX_COMMAND, stdin);
    if (command[0] == '<') {
        for (int i = 1; command[i]; ++i) {
            if (command[i] == '>') {
                finger_command_t result;
                result.name = strdup(trim(command + i + 1));
                result.password = strndup(command + 1, i - 1);
                return result;
            }
        }
        puts("N/A");
        exit(0);
    }
    finger_command_t result;
    result.name = strdup(trim(command));
    result.password = NULL;
    return result;
}

int is_password_required(const char *username) {
    return !strcmp(username, ADMIN_USER);
}

int check_password(const char *password) {
    char *real_password = get_text_contents("/data/password");
    return password && !strncmp(password, real_password, strlen(password));
}
