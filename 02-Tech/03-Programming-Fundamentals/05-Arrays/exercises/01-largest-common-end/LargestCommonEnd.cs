﻿using System;

namespace _01_largest_common_end
{
    class LargestCommonEnd
    {
        static void Main()
        {
            var firstWords = Console.ReadLine().Split(' ');
            var secondWords = Console.ReadLine().Split(' ');


            var end = Math.Min(firstWords.Length, secondWords.Length);
            var commonStart = 0;
            for (int i = 0; i < end; i++)
            {
                if (firstWords[i].Equals(secondWords[i]))
                {
                    commonStart++;
                }
            }

            var commonEnd = 0;
            for (int i = 1; i <= end; i++)
            {
                if (firstWords[firstWords.Length - i].Equals(secondWords[secondWords.Length - i]))
                {
                    commonEnd++;
                }
            }

            var result = Math.Max(commonStart, commonEnd);
            Console.WriteLine(result);
        }
    }
}
