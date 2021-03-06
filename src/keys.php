<?PHP

/***
 * Class keys
 */
class keys
{

    /***
     * @return array
     */
    static function lower()
    {
        return array(
            8 => 14, #  BACK SPACE
            9 => 15, #  TAB
            10 => 28, # NEW LINE
            32 => 57, # SPACE
            39 => 40, # '
            44 => 51, # ,
            45 => 12, # -
            46 => 52, # .
            47 => 53, # /
            48 => 11, # 0
            49 => 2, # 1
            50 => 3, # 2
            51 => 4, # 3
            52 => 5, # 4
            53 => 6, # 5
            54 => 7, # 6
            55 => 8, # 7
            56 => 9, # 8
            57 => 10, # 9
            59 => 39, # ;
            61 => 13, # =
            91 => 26, # [
            92 => 43, # \
            93 => 27, # ]
            96 => 41, # `
            97 => 30, # a
            98 => 48, # b
            99 => 46, # c
            100 => 32, # d
            101 => 18, # e
            102 => 33, # f
            103 => 34, # g
            104 => 35, # h
            105 => 23, # i
            106 => 36, # j
            107 => 37, # k
            108 => 38, # l
            109 => 50, # m
            110 => 49, # n
            111 => 24, # o
            112 => 25, # p
            113 => 16, # q
            114 => 19, # r
            115 => 31, # s
            116 => 20, # t
            117 => 22, # u
            118 => 47, # v
            119 => 17, # w
            120 => 45, # x
            121 => 21, # y
            122 => 44, # z
        );
    }

    /***
     * @return array
     */
    static function upper()
    {
        return array(
            33 => 2, # !
            35 => 4, # #
            36 => 5, # $
            37 => 6, # %
            38 => 8, # &
            39 => 40, # '
            40 => 10, # (
            41 => 11, # )
            42 => 9, # *
            43 => 13, # +
            58 => 39, # :
            60 => 51, # <
            62 => 52, # >
            63 => 53, # ?
            64 => 3, # @
            65 => 30, # A
            66 => 48, # B
            67 => 46, # C
            68 => 32, # D
            69 => 18, # E
            70 => 33, # F
            71 => 34, # G
            72 => 35, # H
            73 => 23, # I
            74 => 36, # J
            75 => 37, # K
            76 => 38, # L
            77 => 50, # M
            78 => 49, # N
            79 => 24, # O
            80 => 25, # P
            81 => 16, # Q
            82 => 19, # R
            83 => 31, # S
            84 => 20, # T
            85 => 22, # U
            86 => 47, # V
            87 => 17, # W
            88 => 45, # X
            89 => 21, # Y
            90 => 44, # Z
            94 => 7, # ^
            95 => 12, # _
            123 => 26, # {
            124 => 43, # |
            125 => 27, # }
            126 => 41, # ~
        );
    }

    /***
     * @return array
     */
    static function control()
    {
        return array(
            'ALT_SYSRQ' => 84,
            'CAPSLOCK' => 58,
            'ERROR' => 0,
            'ESC' => 1,
            'F1' => 59,
            'F10' => 68,
            'F2' => 60,
            'F3' => 61,
            'F4' => 62,
            'F5' => 63,
            'F6' => 64,
            'F7' => 65,
            'F8' => 66,
            'F9' => 67,
            'KEYPAD-.' => 83,
            'KEYPAD_*' => 55,
            'KEYPAD_-' => 74,
            'KEYPAD_0' => 82,
            'KEYPAD_1' => 79,
            'KEYPAD_2' => 80,
            'KEYPAD_3' => 81,
            'KEYPAD_4' => 75,
            'KEYPAD_5' => 76,
            'KEYPAD_6' => 77,
            'KEYPAD_7' => 71,
            'KEYPAD_8' => 72,
            'KEYPAD_9' => 73,
            'KEYPAD_PLUS' => 78,
            'LALT' => 56,
            'LCTRL' => 29,
            'LSHIFT' => 42,
            'NUMLOCK' => 69,
            'PRINTSCREEN' => 55,
            'RSHIFT' => 54,
            'SCROLLLOCK' => 70,
        );
    }
}