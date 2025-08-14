-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2025 at 10:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `execode`
--

-- --------------------------------------------------------

--
-- Table structure for table `contests`
--

CREATE TABLE `contests` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contests`
--

INSERT INTO `contests` (`id`, `title`, `start_time`, `end_time`) VALUES
(1, 'ExeCode Programming Contest #1', '2025-06-20 10:00:00', '2025-06-20 13:00:00'),
(2, 'ExeCode Practice Contest', '2025-06-21 15:00:00', '2025-06-21 18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

CREATE TABLE `problems` (
  `id` int(11) NOT NULL,
  `contest_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `statement` text DEFAULT NULL,
  `input` text DEFAULT NULL,
  `output` text DEFAULT NULL,
  `difficulty` enum('easy','medium','hard') DEFAULT NULL,
  `time_limit` float DEFAULT 2,
  `memory_limit` int(11) DEFAULT 262144
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `problems`
--

INSERT INTO `problems` (`id`, `contest_id`, `title`, `statement`, `input`, `output`, `difficulty`, `time_limit`, `memory_limit`) VALUES
(1, 1, 'Two Sum', 'Given an array of integers nums and an integer target, return indices of the two numbers such that they add up to the target.', '4\n2 7 11 15\n9', '[0,1]', 'easy', 2, 262144),
(2, 1, 'Palindrome Check', 'Check if a given string is a palindrome.', 'racecar', 'Yes', 'easy', 2, 262144),
(3, 2, 'Fibonacci Modulo', 'Print the Nth Fibonacci number modulo 1000000007.', '10', '55', 'medium', 1.5, 262144);

-- --------------------------------------------------------

--
-- Table structure for table `problem_start_times`
--

CREATE TABLE `problem_start_times` (
  `user_id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `opened_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `problem_start_times`
--

INSERT INTO `problem_start_times` (`user_id`, `problem_id`, `opened_at`) VALUES
(1, 1, '2025-06-20 13:53:37'),
(1, 2, '2025-06-20 13:53:47'),
(1, 3, '2025-06-20 14:03:12');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `problem_id` int(11) DEFAULT NULL,
  `code` text DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `status` enum('Pending','Accepted','WA','TLE','RE') DEFAULT NULL,
  `runtime` float DEFAULT NULL,
  `submitted_at` datetime DEFAULT current_timestamp(),
  `output` text DEFAULT NULL,
  `error` text DEFAULT NULL,
  `input` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `user_id`, `problem_id`, `code`, `language`, `status`, `runtime`, `submitted_at`, `output`, `error`, `input`) VALUES
(1, 1, 1, 'function twoSum(nums, target) {\n let map = {};\n for(let i = 0; i < nums.length; i++) {\n let complement = target - nums[i];\n if(map[complement] !== undefined) return [map[complement], i];\n map[nums[i]] = i;\n }\n}', 'javascript', 'Accepted', 0.15, '2025-06-20 10:51:45', '[0,1]', '', '4\n2 7 11 15\n9'),
(2, 1, 1, 'function twoSum(nums, target) {\\n  let map = {};\\n  for(let i = 0; i < nums.length; i++) {\\n    let complement = target - nums[i];\\n    if(map[complement] !== undefined) return [map[complement], i];\\n    map[nums[i]] = i;\\n  }\\n}', 'javascript', 'Accepted', 0.015, '2025-06-20 11:04:17', '', '', '4\\n2 7 11 15\\n9'),
(3, 1, 1, 'function twoSum(nums, target) {\\n  let map = {};\\n  for(let i = 0; i < nums.length; i++) {\\n    let complement = target - nums[i];\\n    if(map[complement] !== undefined) return [map[complement], i];\\n    map[nums[i]] = i;\\n  }\\n}', 'javascript', 'Accepted', 0.015, '2025-06-20 11:30:13', '', '', '4\\n2 7 11 15\\n9'),
(4, 1, 1, '#include <iostream>\\nusing namespace std;\\n\\nint main() {\\n  // Your code here\\n  return 0;\\n}', 'cpp', '', 0.001, '2025-06-20 11:45:10', '', '', '4\\n2 7 11 15\\n9'),
(5, 1, 1, '#include <iostream>\\n#include <vector>\\n#include <unordered_map>\\n\\nusing namespace std;\\n\\nvector<int> twoSum(const vector<int>& nums, int target) {\\n    unordered_map<int, int> map; // number -> index\\n\\n    for (int i = 0; i < nums.size(); i++) {\\n        int complement = target - nums[i];\\n        // Check if complement exists in map\\n        if (map.find(complement) != map.end()) {\\n            return {map[complement], i};\\n        }\\n        // Store current number and its index\\n        map[nums[i]] = i;\\n    }\\n    // If no solution found (problem guarantees one)\\n    return {};\\n}\\n\\nint main() {\\n    vector<int> nums = {2, 7, 11, 15};\\n    int target = 9;\\n    vector<int> result = twoSum(nums, target);\\n\\n    if (!result.empty()) {\\n        cout << \\\"Indices: \\\" << result[0] << \\\", \\\" << result[1] << endl;\\n    } else {\\n        cout << \\\"No solution found.\\\" << endl;\\n    }\\n    return 0;\\n}\\n', 'cpp', '', 0.003, '2025-06-20 11:46:16', 'Indices: 0, 1\\n', '', '4\\n2 7 11 15\\n9'),
(6, 1, 1, '#include <iostream>\\n#include <vector>\\n#include <unordered_map>\\n\\nusing namespace std;\\n\\nvector<int> twoSum(const vector<int>& nums, int target) {\\n    unordered_map<int, int> map; // number -> index\\n\\n    for (int i = 0; i < nums.size(); i++) {\\n        int complement = target - nums[i];\\n        if (map.find(complement) != map.end()) {\\n            return {map[complement], i};\\n        }\\n        map[nums[i]] = i;\\n    }\\n    return {};\\n}\\n\\nint main() {\\n    vector<int> nums = {2, 7, 11, 15};\\n    int target = 9;\\n    vector<int> result = twoSum(nums, target);\\n\\n    if (!result.empty()) {\\n        cout << \\\"[\\\" << result[0] << \\\",\\\" << result[1] << \\\"]\\\";\\n    } else {\\n        cout << \\\"No solution found.\\\";\\n    }\\n\\n    return 0;\\n}\\n', 'cpp', 'Accepted', 0.002, '2025-06-20 11:51:31', '[0,1]', '', '4\\n2 7 11 15\\n9'),
(7, 1, 1, '#include <iostream>\\nusing namespace std;\\n\\nint main() {\\n  // Your code here\\n  return 0;\\n}', 'cpp', '', 0.002, '2025-06-20 12:08:18', '', '', '4\\n2 7 11 15\\n9'),
(8, 1, 1, '#include <iostream>\\n#include <vector>\\n#include <unordered_map>\\n\\nusing namespace std;\\n\\nvector<int> twoSum(const vector<int>& nums, int target) {\\n    unordered_map<int, int> map; // number -> index\\n\\n    for (int i = 0; i < nums.size(); i++) {\\n        int complement = target - nums[i];\\n        if (map.find(complement) != map.end()) {\\n            return {map[complement], i};\\n        }\\n        map[nums[i]] = i;\\n    }\\n    return {};\\n}\\n\\nint main() {\\n    vector<int> nums = {2, 7, 11, 15};\\n    int target = 9;\\n    vector<int> result = twoSum(nums, target);\\n\\n    if (!result.empty()) {\\n        cout << \\\"[\\\" << result[0] << \\\",\\\" << result[1] << \\\"]\\\";\\n    } else {\\n        cout << \\\"No solution found.\\\";\\n    }\\n\\n    return 0;\\n}\\n', 'cpp', 'Accepted', 0.001, '2025-06-20 12:11:37', '[0,1]', '', '4\\n2 7 11 15\\n9'),
(9, 1, 2, '#include <iostream>\\nusing namespace std;\\n\\nint main() {\\n  // Your code here\\n  return 0;\\n}', 'cpp', '', 0.001, '2025-06-20 12:11:54', '', '', 'racecar'),
(10, 1, 1, '#include <iostream>\\n#include <vector>\\n#include <unordered_map>\\nusing namespace std;\\n\\nvector<int> twoSum(vector<int>& nums, int target) {\\n    unordered_map<int, int> numMap; // value -> index\\n    for (int i = 0; i < nums.size(); ++i) {\\n        int complement = target - nums[i];\\n        if (numMap.find(complement) != numMap.end()) {\\n            return {numMap[complement], i};\\n        }\\n        numMap[nums[i]] = i;\\n    }\\n    return {};\\n}\\n\\nint main() {\\n    int n, target;\\n    cin >> n;\\n\\n    vector<int> nums(n);\\n    for (int i = 0; i < n; ++i)\\n        cin >> nums[i];\\n\\n    cin >> target;\\n\\n    vector<int> result = twoSum(nums, target);\\n    if (!result.empty())\\n        cout << \\\"[\\\" << result[0] << \\\",\\\" << result[1] << \\\"]\\\" << endl;\\n    else\\n        cout << \\\"No solution found\\\" << endl;\\n\\n    return 0;\\n}\\n', 'cpp', 'Accepted', 0.002, '2025-06-20 13:55:41', '[0,1]\\n', '', '4\\n2 7 11 15\\n9'),
(11, 1, 2, '#include <iostream>\\n#include <string>\\nusing namespace std;\\n\\nbool isPalindrome(const string& str) {\\n    int left = 0;\\n    int right = str.length() - 1;\\n    while (left < right) {\\n        if (str[left] != str[right])\\n            return false;\\n        ++left;\\n        --right;\\n    }\\n    return true;\\n}\\n\\nint main() {\\n    string input;\\n    cin >> input;\\n\\n    if (isPalindrome(input))\\n        cout << \\\"Yes\\\" << endl;\\n    else\\n        cout << \\\"No\\\" << endl;\\n\\n    return 0;\\n}\\n', 'cpp', 'Accepted', 0.002, '2025-06-20 14:02:11', 'Yes\\n', '', 'racecar'),
(12, 1, 3, '#include <iostream>\\nusing namespace std;\\n\\nconst int MOD = 1000000007;\\n\\nint fibonacci(int n) {\\n    if (n == 0) return 0;\\n    if (n == 1) return 1;\\n\\n    long long prev = 0, curr = 1;\\n    for (int i = 2; i <= n; ++i) {\\n        long long next = (prev + curr) % MOD;\\n        prev = curr;\\n        curr = next;\\n    }\\n    return curr;\\n}\\n\\nint main() {\\n    int n;\\n    cin >> n;\\n    cout << fibonacci(n) << endl;\\n    return 0;\\n}\\n', 'cpp', 'Accepted', 0.001, '2025-06-20 14:04:10', '55\\n', '', '10');

-- --------------------------------------------------------

--
-- Table structure for table `users_info`
--

CREATE TABLE `users_info` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_info`
--

INSERT INTO `users_info` (`id`, `username`, `email`, `password`) VALUES
(1, 'mahbub', 'mrahman221441@bscse.uiu.ac.bd', '12345678'),
(2, 'musfiqur', 'musfiq@gmail.com', 'password123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contests`
--
ALTER TABLE `contests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contest_id` (`contest_id`);

--
-- Indexes for table `problem_start_times`
--
ALTER TABLE `problem_start_times`
  ADD PRIMARY KEY (`user_id`,`problem_id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `problem_id` (`problem_id`);

--
-- Indexes for table `users_info`
--
ALTER TABLE `users_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contests`
--
ALTER TABLE `contests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users_info`
--
ALTER TABLE `users_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `problems`
--
ALTER TABLE `problems`
  ADD CONSTRAINT `problems_ibfk_1` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`);

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users_info` (`id`),
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`problem_id`) REFERENCES `problems` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
