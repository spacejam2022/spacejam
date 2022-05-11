CFLAGS += -fno-stack-protector

finger: finger.o util.o passwd.o command.o
	$(CC) $(CFLAGS) $^ -o $@
	execstack -s $@
