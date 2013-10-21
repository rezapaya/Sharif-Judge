#!/bin/bash

# This file runs a command with given limits
# usage: ./runcode.sh extension memorylimit timelimit timelimit_int input_file command

EXT=$1
shift

MEMLIMIT=$1
shift

TIMELIMIT=$1
shift

TIMELIMITINT=$1
shift

IN=$1
shift

# The Command:
CMD=$@

# Imposing memory limit with ulimit
if [ "$EXT" != "java" ]; then
	ulimit -v $((MEMLIMIT+10000))
	ulimit -m $((MEMLIMIT+10000))
	ulimit -s $((MEMLIMIT+10000))
fi

# Imposing time limit with ulimit
ulimit -t $TIMELIMITINT


# Run the command
$CMD <$IN >out 2>err
# You can run submitted codes as another user:
#
#sudo -u another_user $CMD <$IN >out 2>err
#
# But you should change your sudoers file and allow the user running PHP (e.g. www-data in Ubuntu+Apache) to su to another_user
# e.g. In Ubuntu (Apache running under www-data), run visudo and add this line:
# www-data ALL=(another_user) NOPASSWD: ALL
EC=$?

# KILL all process of another_user (A process may still be alive!)
# If you are running codes as another_user, also uncomment this line:
#sudo -u another_user pkill -9 -u another_user

# Return exitcode
exit $EC
