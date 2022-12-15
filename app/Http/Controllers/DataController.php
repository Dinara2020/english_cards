<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 3600);
use App\Models\Words;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataController extends Controller
{
    public function start(int $id = null, string $direction = null)
    {
//        $all = Words::get();
//        foreach ($all as $word) {
//            $img = $word->sound;
//            $img = str_replace("[sound:",'',$img);
//            $img = str_replace("]",'',$img);
//            $word->sound = $img;
//            $word->save();
//        }
        if (!$direction) {
            $stat = Words::getStatistic();
            $word = Words::getWord($id);
            return view('start', ['word' => $word,'stat' => $stat]);
        }
        if ($id === null) {
            $id = 1;
        }
        else {
            if ($direction && $direction === 'next') {
                $id = $id + 1;
            } elseif ($direction && $direction === 'back') {
                $id = $id - 1;
                if ($id === 0) {
                    $id = Words::getMaxId();
                }
            }
        }

//        $word = Words::getWord($id);
//        if (in_array($word->status, ['delete', 'done'])) {
//            return redirect()->action(
//                [DataController::class,'start'], ['id' => $id]
//            );
//        }
        return redirect()->action(
            [DataController::class,'start'], ['id' => $id]
        );
    }

    public function update(string $method, int $id)
    {
        $word = Words::find($id);
        $word->status = $method;
        $word->status_time = Carbon::now()->format('Y-m-d');
        $word->save();
        return redirect('test/'.$id);
    }

    public static function getWords()
    {
        return Words::getWords();
    }

    public function updateVocabulary ()
    {
        //$result = addcslashes(Storage::disk('local')->get('lingualeo.csv'));
        function kama_parse_csv_file($file_path, $file_encodings = ['cp1251', 'UTF-8'], $col_delimiter = '', $row_delimiter = '')
        {

            if (!file_exists($file_path)) {
                return 'error';
            }

            $cont = trim(file_get_contents($file_path));

            $encoded_cont = mb_convert_encoding($cont, 'UTF-8', mb_detect_encoding($cont, $file_encodings));

            unset($cont);

            // определим разделитель
            if (!$row_delimiter) {
                $row_delimiter = "\r\n";
                if (false === strpos($encoded_cont, "\r\n"))
                    $row_delimiter = "\n";
            }

            $lines = explode($row_delimiter, trim($encoded_cont));
            $lines = array_filter($lines);
            $lines = array_map('trim', $lines);

            // авто-определим разделитель из двух возможных: ';' или ','.
            // для расчета берем не больше 30 строк
            if (!$col_delimiter) {
                $lines10 = array_slice($lines, 0, 30);

                // если в строке нет одного из разделителей, то значит другой точно он...
                foreach ($lines10 as $line) {
                    if (!strpos($line, ',')) $col_delimiter = ';';
                    if (!strpos($line, ';')) $col_delimiter = ',';

                    if ($col_delimiter) break;
                }

                // если первый способ не дал результатов, то погружаемся в задачу и считаем кол разделителей в каждой строке.
                // где больше одинаковых количеств найденного разделителя, тот и разделитель...
                if (!$col_delimiter) {
                    $delim_counts = array(';' => array(), ',' => array());
                    foreach ($lines10 as $line) {
                        $delim_counts[','][] = substr_count($line, ',');
                        $delim_counts[';'][] = substr_count($line, ';');
                    }

                    $delim_counts = array_map('array_filter', $delim_counts); // уберем нули

                    // кол-во одинаковых значений массива - это потенциальный разделитель
                    $delim_counts = array_map('array_count_values', $delim_counts);

                    $delim_counts = array_map('max', $delim_counts); // берем только макс. значения вхождений

                    if ($delim_counts[';'] === $delim_counts[','])
                        return array('Не удалось определить разделитель колонок.');

                    $col_delimiter = array_search(max($delim_counts), $delim_counts);
                }

            }

            $data = [];
            foreach ($lines as $key => $line) {
                $data[] = str_getcsv($line, $col_delimiter); // linedata
                unset($lines[$key]);
            }

            return $data;
        }

        $data = kama_parse_csv_file(storage_path('app/lingualeo.csv'));

        foreach ($data as $word) {
            $wordCheck = Words::where('word', '=', $word[0])->first();
            if ($wordCheck === null) {
                $newWord = new Words();
                $newWord->word = $word[0];
                $newWord->translation = $word[1];
                $newWord->pic = $word[2];
                $newWord->pron = $word[3];
                $newWord->phrase = $word[4];
                $newWord->type = $word[8];
                $newWord->sound = $word[5];
                $newWord->save();
            }
        }
    }
}