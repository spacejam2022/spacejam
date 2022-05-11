#ifndef __COMMAND_H
#define __COMMAND_H

#define MAX_COMMAND 4096
#define ADMIN_USER "admin"

typedef struct finger_command {
    char *name;
    char *password;
} finger_command_t;

finger_command_t read_command();
int is_password_required(const char *username);
int check_password(const char *password);

#endif /* !__COMMAND_H */
