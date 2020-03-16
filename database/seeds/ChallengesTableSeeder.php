<?php

use Illuminate\Database\Seeder;
use App\Challenge;


class ChallengesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->fake();
        $this->tatu();
    }

    private function addChallenge($name,$description,$difficulty,$targetSolution,$category,$hint,$flag,$author)
    {
        Challenge::create(
            [
                'name' => $name,
                'description' => $description,
                'difficulty' => $difficulty,
                'targetSolution' => $targetSolution,
                'category' => $category,
                'hint' => $hint,
                'flag' => $flag,
                'author' => $author
            ]
        )->save();
    }

    //Create TaTu challenges
    private function tatu()
    {
        $this->addChallenge('Caesar-Chiffre','Die Caesar-Chiffre wurde zu Ehren von Julius Caesar
        benannt. Sie wurde zur Verschlüsselung von militärischen und anderen offiziellen Nachrichten verwendet.
        Es werden dabei alle Buchstaben um 3 weiter im Alphabet gedreht. Löse die Cesar-Chiffre, um die Flagge zu erhalten.
        Die Flagge sollte nach dem entschlüsseln so aussehen: "HTL{Text}". Die verschlüsselte Nachricht lautet: Klhu lvw ghlqh Iodjjh: KWO{LW-QZWN}',
            'easy','Use a online-decoder.','cryptography',
            'Verwende eine Website wie: https://www.dcode.fr/caesar-cipher um die Nachricht zu entschlüsseln.
             Die Rotation (auch Shift genannt) ist 3!','HTL{IT-NWTK}','Roman Schabus');

        $this->addChallenge('Bin2ASCII','Binäre Zeichen werden verwendet, um Daten in einem Computersystem zu verwalten.
Die folgenden Zeichen sind eine Binäre Darstellung von einem Text. Schaffst du es den Text von Binären Darstellung wieder
 in Text zu verwandeln, um die Flagge zu erhalten? Die Flagge sollte dann so aussehen: "HTL{Text}". 01001000 01010100 01001100 01111011
  01000011 01101111 01101101 01110000 01110101 01110100 01100101 01110010 01011111 01110010 01100101 01100100 01100101 01101110 01011111
  00110000 01011111 01110101 01101110 01100100 01011111 00110001 01111101','easy','Use a online decoder.',
            'miscellaneous',
            'Verwende einen Übersetzer wie diesen:  https://www.rapidtables.com/convert/number/binary-to-ascii.html',
            'HTL{Computer_reden_0_und_1}','Roman Schabus/Simon Possegger');

        $this->addChallenge('Hex2ASCII','Du hast folgende Hexadezimale Zeichen bekommen. Kannst du es schaffen sie in normalen
Zeichen zu übersetzen? Die Flagge sollte dann so aussehen: "HTL{Text}". 48 54 4c 7b 54 61 54 fc 5f 48 54 4c 2d 56 69 6c 6c 61 63 68 7d'
            ,'easy','Use a online decoder.','miscellaneous','Verwende einen Übersetzer wie diesen:
             https://www.rapidtables.com/convert/number/hex-to-ascii.html','HTL{TaTü_HTL-Villach}','Roman Schabus');

        $this->addChallenge('ROT13','Rot13 ist eine Verschlüsselung, welche alle Buchstaben um 13 Zeichen versetzt. Kannst du es
schaffen den Code zu knacken, um die Flagge zu erhalten? Die Flagge sollte dann so aussehen: "HTL{Text}". Der verschlüsselte Text: UGY{Plore-Frphevgl}',
            'medium','Use a online decoder.','cryptography','Verwende eine Webseite wie diese: https://rot13.com/, um die Flagge zu entschlüsseln','HTL{Cyber-Security}','Roman Schabus');
    }

    //Create fake challenges for testing
    private function fake()
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= 20; $i++)
        {
            $challenge = new Challenge();
            $challenge->name = "Challenge" . $i;
            $challenge->description = $faker->text;
            if($i % 2 == 0)
            {
                $challenge->difficulty = "easy";
                $challenge->targetSolution = $faker->text;
                $challenge->category = "miscellaneous";
                $challenge->hint = $faker->text;
            }
            else if($i % 3 == 0)
            {
                $challenge->difficulty = "medium";
                $challenge->category = "web";
            }
            else
            {
                $challenge->difficulty = "hard";
                $challenge->targetSolution = $faker->text;
                $challenge->active=false;
                $challenge->hint = "You have to haxx0r the binary.";
                $challenge->category = "pwn";
            }

            $challenge->flag = "WTH{" . $faker->md5 . "}";
            $challenge->author = $faker->name;
            //$challenge->imageID = $faker->bankAccountNumber;
            $challenge->save();
        }
    }
}
